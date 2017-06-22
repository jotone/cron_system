<?php
namespace App\Http\Controllers\Supply;

use App\Brand;
use App\Category;
use App\FooterMenu;
use App\EtcData;
use App\Products;
use App\SocialMenu;
use Illuminate\Http\Request;
use App\TopMenu;
use Auth;
use Illuminate\Support\Facades\Crypt;
use URL;

use Illuminate\Routing\Controller as BaseController;

class Helpers extends BaseController{
	public $upcase;
	public $locase;

	public function __construct(){
		$this->upcase = 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯІЇЄABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$this->locase = 'абвгдеёжзийклмнопрстуфхцчшщьыъэюяіїєabcdefghijklmnopqrstuvwxyz';
	}

	public function mb_str_split($str){
		preg_match_all('/.{1}|[^\x00]{1}$/us', $str, $ar);
		return $ar[0];
	}

	public function mb_strtr($str, $from, $to){
		return str_replace($this->mb_str_split($from), $this->mb_str_split($to), $str);
	}

	public function lowercase($arg){
		return $this->mb_strtr($arg, $this->upcase, $this->locase);
	}

	public function uppercase($arg){
		return $this->mb_strrt($arg, $this->upcase, $this->locase);
	}

	public static function getDefaults(){
		$top_menu = TopMenu::select('title','slug')->where('enabled','=',1)->orderBy('position','asc')->get();
		$footer_menu = FooterMenu::select('title','slug','is_outer')->where('enabled','=',1)->orderBy('position','asc')->get();
		$brands = self::buildBrandList();

		$etc_data = EtcData::select('key','value')->where('label','=','info')->get();
		$info = [];
		foreach($etc_data as $item){
			$info[$item->key] = $item->value;
		}

		$social_menu = SocialMenu::select('title','slug','link')->orderBy('position','asc')->get();
		$social = [];
		foreach($social_menu as $item){
			switch($item->slug){
				case 'facebook':	$image = URL::asset('images/fb.png'); break;
				case 'google_plus':	$image = URL::asset('images/gg.png'); break;
				case 'vkontakte':	$image = URL::asset('images/vk.png'); break;
				default: $image = '';
			}
			$social[] = [
				'title'	=> $item->title,
				'link'	=> $item->link,
				'img_url'=>$image
			];
		}

		return [
			'top_menu'	=> $top_menu,
			'footer_menu'=>$footer_menu,
			'brands'	=> $brands,
			'info'		=> $info,
			'social'	=> $social
		];
	}

	public static function buildBrandList($refer_to = 0, $parent = '', $result = ''){
		$items = Brand::select('id','title','slug')
			->where('refer_to','=',$refer_to)
			->where('enabled','=',1)
			->orderBy('position','asc')
			->get();
		if(!empty($items->all())){

			$n = count($items);
			if($refer_to == 0) {
				$result .= '<ul class="menu-list">';
			}else{
				$result .= ($n > 15)? '<div>': '<ul>';
			}

			for($i = 0; $i<$n; $i++){
				if($refer_to == 0){
					$parent = $items[$i]->slug.'/';
					$link = $items[$i]->slug;
				}else{
					$link = $parent.$items[$i]->slug;
				}

				if( (count($items) > 15) && ($i%15 == 0) )
					$result .= '<ul>';

				$inner_count = Brand::where('refer_to','=',$items[$i]->id)->count();
				$wide_class = ( ($refer_to == 0) && ($inner_count > 15) )? 'class="wide"': '';

				$result .= '<li '.$wide_class.'><a href="'.route('brand', $link).'">'.$items[$i]->title.'</a>';

				if($inner_count > 0){
					$result .= self::buildBrandList($items[$i]->id, $parent);
				}
				$result .= '</li>';

				if( (count($items) > 15) && (($i%15 == 14) || ($i == $n-1)) )
					$result .= '</ul>';
			}
			$result .= ($n > 15)? '</div>': '</ul>';
		}
		return $result;
	}

	public function changePerPage(Request $request){
		$data = $request->all();
		if(isset($data['per_page'])){
			$data['per_page'] = intval($data['per_page']);
			setcookie('per_page',$data['per_page'], time()+36000, '/');
			return 'success';
		}
	}

	public function changeFilter(Request $request){
		$data = $request->all();

		if(isset($data['filter'])){
			if(isset($_COOKIE['catalog_filter'])){
				$catalog_filter = get_object_vars(json_decode($_COOKIE['catalog_filter']));
				$catalog_filter[$data['filter'][0]] = $data['filter'][1];
			}else{
				$catalog_filter[$data['filter'][0]] = $data['filter'][1];
			}
			setcookie('catalog_filter', json_encode($catalog_filter), time()+36000, '/');

			$limit = (isset($_COOKIE['per_page']))? $_COOKIE['per_page']: 8;

			$products = Products::select('id','title','img_url','text','old_price','price','is_hot')->where('enabled','=',1);
			foreach($catalog_filter as $key => $value){
				switch($key){
					case 'category':
						$category = Category::select('id')->where('slug','=',$value)->first();
						$products = $products->where('refer_to_category','=',$category->id);
					break;

					case 'brand':
						$brand = Brand::select('id')->where('slug','=',$value)->first();
						$products = $products->where('refer_to_brand','=',$brand->id);
					break;

					case 'price':
						$prices = json_decode($value);
						if( (empty($prices->min)) || ($prices->min < 1) ){
							$prices->min = 1;
						}
						$products = $products->where('price','>=',$prices->min);

						if( (!empty($prices->max)) && ($prices->max >= 1) ){
							$products = $products->where('price','<=',$prices->max);
						}
					break;

					case 'rating':
						$products = $products->where('rating','=',$value);
					break;
				}
			}
			$products_count = $products->count();
			$products = $products->take($limit)->get();

			$product_list = [];
			foreach($products as $product){
				switch($product->is_hot){
					case '1':	$is_hot = 'hot'; break;
					case '2':	$is_hot = 'sale'; break;
					default:	$is_hot = '';
				}
				$product_list[] = [
					'id'		=> Crypt::encrypt($product->id),
					'title'		=> $product->title,
					'img_url'	=> json_decode($product->img_url),
					'text'		=> $product->text,
					'price'		=> $product->price,
					'old_price'	=> $product->old_price,
					'formatted_price' => number_format($product->price, 0, '', ' '),
					'formatted_old_price' => number_format($product->old_price, 0, '', ' '),
					'is_hot'	=> $is_hot
				];
			}

			$paginate_options = [
				'prev'		=> $data['page']-1,
				'next'		=> $data['page']+1,
				'current'	=> $data['page'],
				'total'		=> ceil($products_count/$limit)
			];

			return json_encode([
				'message'	=> 'success',
				'products'	=> $product_list,
				'pagination'=> $paginate_options
			]);

		}elseif(isset($data['reset'])){
			setcookie('catalog_filter', '', time()+36000, '/');
			return json_encode(['message'=>'reset']);
		}
	}

	public function filterBrand(Request $request){
		$data = $request->all();
		if( (isset($data['word'])) && (strlen($data['word']) > 1) ){
			$data['word'] = $this->lowercase($data['word']);
			$brands = Brand::select('title','slug')
				->where('enabled','=','1')
				->where('title','LIKE','%'.$data['word'].'%')
				->where('refer_to','=',0)
				->take(10)
				->get();
			$result = [];
			foreach($brands as $brand){
				$result[] = [
					'title'	=> $brand->title,
					'slug'	=> $brand->slug
				];
			}
			return json_encode([
				'message' => 'success',
				'items' => $result
			]);
		}else{
			return json_encode([
				'message' => 'success',
				'items' => []
			]);
		}
	}

	public function getShoppingCartByRequest(){
		return json_encode([
			'message' => 'success',
			'items' => self::getShoppingCart()
		]);
	}

	public static function getShoppingCart(){
		$items = ( (isset($_COOKIE['shopping_cart'])) && (!empty($_COOKIE['shopping_cart'])) )
			? get_object_vars(json_decode($_COOKIE['shopping_cart']))
			: [];

		$product_list = [];
		foreach($items as $item_id => $quantity){
			$product = Products::find($item_id);

			$product_list[] = [
				'id' => $product->id,
				'title' => $product->title,
				'img_url' => json_decode($product->img_url),
				'price' => $product->price,
				'quantity' => $quantity
			];
		}
		return $product_list;
	}
}