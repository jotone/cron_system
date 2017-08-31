<?php
namespace App\Http\Controllers\Site;

use App\Brand;
use App\Category;
use App\Pages;
use App\Products;
use App\Http\Controllers\Supply\Functions;
use App\Http\Controllers\Supply\Helpers;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Validator;

class ProductController extends BaseController{

	protected static function getInnerBrands($brand_id, $result = ''){
		$inner_count = Brand::select('id')->where('refer_to','=',$brand_id)->where('enabled','=',1)->count();
		if($inner_count > 0){
			$inner = Brand::select('id','is_last')->where('refer_to','=',$brand_id)->where('enabled','=',1)->get();
			foreach($inner as $item){
				if($item->is_last > 0){
					$result .= $item->id.',';
				}else{
					$result = self::getInnerBrands($item->id, $result);
				}
			}
		}else{
			$result .= $brand_id.',';
		}
		return $result;
	}

	protected static function findLastBrand($brand_data){
		$result = '';
		if($brand_data->is_last < 1){
			$sub_brands = Brand::select('id','is_last')
				->where('refer_to','=',$brand_data->id)
				->where('enabled','=',1)
				->get();
			foreach($sub_brands as $sub_brand){
				$result .= self::findLastBrand($sub_brand);
			}
		}else{
			$result = self::getInnerBrands($brand_data->id);
		}
		return $result;
	}

	protected static function findLastBrandWithProducts($parent_brand_id, $result = []){
		$inner_brands = Brand::select('id','title','slug','is_last')
			->where('refer_to','=',$parent_brand_id)
			->where('enabled','=',1)
			->get();
		foreach($inner_brands as $brand_data){
			if($brand_data->is_last == 1){
				$brand_products_count = Products::where('refer_to_brand','=',$brand_data->id)->where('enabled','=',1)->count();
				if($brand_products_count > 0){
					$result[] = [
						'title'	=> $brand_data->title,
						'slug'	=> $brand_data->slug,
					];
				}
			}else{
				$temp = self::findLastBrandWithProducts($brand_data->id);
				foreach($temp as $item) $result[] = $item;
			}
		}
		return $result;
	}

	public function redirectToCatalog(){
		return redirect(route('catalog'));
	}

	public function brand($brand = '', $slug = '', $page = 1){
		$defaults = Helpers::getDefaults();

		if(preg_match('/^\d+$/',$slug) > 0){
			$page = $slug;
			$brand_slug = $brand;
			$link = $brand;
		}else{
			$brand_slug = (empty($slug))? $brand: $slug;
			$link = $brand.'/'.$slug;
		}

		$path = \Route::current()->getName();
		$page_content = Pages::where('link','LIKE', '%'.$path.'%')->first();
		$meta_data = [
			'title'		=> $page_content->meta_title,
			'keywords'	=> $page_content->meta_keywords,
			'description'=>$page_content->meta_description
		];
		$seo = [
			'need_seo'	=> $page_content->need_seo,
			'title'		=> $page_content->seo_title,
			'text'		=> $page_content->seo_text
		];

		$brand_data = Brand::select('id','title','slug','is_last','refer_to','need_seo','seo_title','seo_text')
			->where('slug','=',$brand_slug)
			->where('enabled','=',1)
			->first();
		$seo = [
			'need_seo'	=> $brand_data->need_seo,
			'title'		=> $brand_data->seo_title,
			'text'		=> $brand_data->seo_text
		];
		$inner_brands = explode(',', self::findLastBrand($brand_data));
		$inner_brands = array_diff($inner_brands, array(''));
		//dd($inner_brands);

		foreach($inner_brands as $brand_id){
			$items = Products::select('id','title','slug','img_url','text','price','old_price','is_hot')
				->where('refer_to_brand','=',$brand_id)
				->where('enabled','=',1)
				->get();
			foreach($items as $item){
				if(!isset($products[$item->id])){
					switch($item->is_hot){
						case '1':	$is_hot = 'hot'; break;
						case '2':	$is_hot = 'sale'; break;
						default:	$is_hot = '';
					}
					$products[$item->id] = [
						'id'		=> Crypt::encrypt($item->id),
						'title'		=> $item->title,
						'slug'		=> $item->slug,
						'img_url'	=> json_decode($item->img_url),
						'text'		=> $item->text,
						'price'		=> number_format($item->price, 0, '',' '),
						'old_price'	=> number_format($item->old_price, 0, '',' '),
						'is_hot'	=> $is_hot,
					];
				}
			}
		}
		$products = array_values($products);

		$limit = (isset($_COOKIE['per_page']))? $_COOKIE['per_page']: 8;
		if($limit < 2) $limit = 8;
		$start = ($page-1) * $limit;
		$products_count = count($products);
		$products = array_slice($products, $start, $limit);

		$parent_brand = Brand::select('id')->where('slug','=',$brand)->first();
		$products_list = self::findLastBrandWithProducts($parent_brand->id);
		usort($products_list, function($a, $b){
			return strcmp($a['title'], $b['title']);
		});

		$paginate_options = [
			'prev'		=> $page-1,
			'next'		=> $page+1,
			'current'	=> $page,
			'total'		=> ceil($products_count/$limit)
		];

		$bread_crumbs = array_reverse(Helpers::getBrandHierarchy($brand_slug));

		return view('brand', [
			'defaults'		=> $defaults,
			'products'		=> $products,
			'paginate_options'=> $paginate_options,
			'page_title'	=> $brand_data->title,
			'bread_crumbs'	=> $bread_crumbs,
			'link'			=> $link,
			'products_list'	=> $products_list,
			'parent_brand'	=> $brand,
			'limit'			=> $limit,
			'meta_data'		=> $meta_data,
			'seo'			=> $seo
		]);
	}

	public function catalog($page = 1){
		$defaults = Helpers::getDefaults();

		$limit = (isset($_COOKIE['per_page']))? $_COOKIE['per_page']: 8;
		if($limit < 8) $limit = 8;

		$start = ($page-1) * $limit;

		$path = \Route::current()->getName();
		$page_content = Pages::where('link','LIKE', '%'.$path.'%')->first();
		$meta_data = [
			'title'		=> $page_content->meta_title,
			'keywords'	=> $page_content->meta_keywords,
			'description'=>$page_content->meta_description
		];
		$seo = [
			'need_seo'	=> $page_content->need_seo,
			'title'		=> $page_content->seo_title,
			'text'		=> $page_content->seo_text
		];

		$categories = Category::select('slug','title')
			->where('enabled','=',1)
			->orderBy('position','asc')
			->get();

		$brands = Brand::select('slug','title')
			->where('refer_to','=',0)
			->where('enabled','=',1)
			->orderBy('position','asc')
			->get();

		$products = Products::select('id','title','slug','text','img_url','old_price','price','is_hot')
			->where('enabled','=',1);
		if( (isset($_COOKIE['catalog_filter'])) && (!empty($_COOKIE['catalog_filter'])) ){
			$catalog_filter = get_object_vars(json_decode($_COOKIE['catalog_filter']));
			foreach($catalog_filter as $key => $value){
				switch($key){
					case 'category':
						$category = Category::select('id')->where('slug','=',$value)->first();
						$products = $products->where('refer_to_category','=',$category->id);
					break;

					case 'brand':
						$brand = Brand::select('id')->where('slug','=',$value)->first();
						$ids = Functions::getChildBrandIDArray([$brand->id]);
						//$in = '(' . implode(',', $ids) .')';
						$products = $products->whereIn('refer_to_brand',$ids); 
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
						$products = $products->where('rating','=',str_replace(['"'],'',$value));
					break;
				}
			}
		}
		$products_count = $products->count();
		$products = $products->orderBy('title','asc')->skip($start)->take($limit)->get();

		$list = [];
		foreach($products as $product){
			switch($product->is_hot){
				case '1':	$is_hot = 'hot'; break;
				case '2':	$is_hot = 'sale'; break;
				default:	$is_hot = '';
			}
			$list[] = [
				'id'		=> Crypt::encrypt($product->id),
				'title'		=> $product->title,
				'slug'		=> $product->slug,
				'text'		=> $product->text,
				'img_url'	=> json_decode($product->img_url),
				'old_price'	=> number_format($product->old_price, 0, '',' '),
				'price'		=> number_format($product->price, 0, '',' '),
				'is_hot'	=> $is_hot
			];
		}

		$paginate_options = [
			'prev'		=> $page-1,
			'next'		=> $page+1,
			'current'	=> $page,
			'total'		=> ceil($products_count/$limit)
		];
		$filter_res=[];
		if(isset($_COOKIE['catalog_filter']) && (!empty($_COOKIE['catalog_filter']))){
			$filter_res=get_object_vars(json_decode($_COOKIE['catalog_filter']));
		}
		return view('catalog', [
			'defaults'		=> $defaults,
			'categories'	=> $categories,
			'brands'		=> $brands,
			'limit'			=> $limit,
			'products'		=> $list,
			'paginate_options'=> $paginate_options,
			'meta_data'		=> $meta_data,
			'seo'			=> $seo,
			'start'			=> $start,
			'limit'			=> $limit,
			'filter'		=>$filter_res,
			'price_range'	=>Functions::getMinMaxPrice()
		]);
	}

	public function specialOffers($page = 1){
		$defaults = Helpers::getDefaults();

		$limit = (isset($_COOKIE['per_page']))? $_COOKIE['per_page']: 8;
		if($limit < 8) $limit = 8;

		$start = ($page-1) * $limit;

		$path = \Route::current()->getName();
		$page_content = Pages::where('link','LIKE', '%'.$path.'%')->first();
		$meta_data = [
			'title'		=> $page_content->meta_title,
			'keywords'	=> $page_content->meta_keywords,
			'description'=>$page_content->meta_description
		];
		$seo = [
			'need_seo'	=> $page_content->need_seo,
			'title'		=> $page_content->seo_title,
			'text'		=> $page_content->seo_text
		];

		$products = Products::select('id','title','slug','text','img_url','old_price','price','is_hot')
			->where('is_hot','=',2)
			->where('enabled','=',1);

		$products_count = $products->count();
		$products = $products->orderBy('title','asc')->skip($start)->take($limit)->get();

		$list = [];
		foreach($products as $product){
			switch($product->is_hot){
				case '1':	$is_hot = 'hot'; break;
				case '2':	$is_hot = 'sale'; break;
				default:	$is_hot = '';
			}
			$list[] = [
				'id'		=> Crypt::encrypt($product->id),
				'title'		=> $product->title,
				'slug'		=> $product->slug,
				'text'		=> $product->text,
				'img_url'	=> json_decode($product->img_url),
				'old_price'	=> number_format($product->old_price, 0, '',' '),
				'price'		=> number_format($product->price, 0, '',' '),
				'is_hot'	=> $is_hot
			];
		}

		$paginate_options = [
			'prev'		=> $page-1,
			'next'		=> $page+1,
			'current'	=> $page,
			'total'		=> ceil($products_count/$limit)
		];

		return view('special_offers', [
			'defaults'		=> $defaults,
			'page_title'	=> $page_content->title,
			'limit'			=> $limit,
			'products'		=> $list,
			'paginate_options'=> $paginate_options,
			'meta_data'		=> $meta_data,
			'seo'			=> $seo
		]);
	}

	public function search($page=1){
		$defaults = Helpers::getDefaults();
		$limit = 8;
		$start = ($page-1) * $limit;
		$searh_request='';

		if(isset($_GET['search']) && $_GET['search']!=''){
			$searh_request=$_GET['search'];
			$products = Products::select('id','title','slug','text','img_url','old_price','price','is_hot')
				->where('title','LIKE','%'.$_GET['search'].'%')
				->where('enabled','=',1);
		}else{
			$products = Products::select('id','title','slug','text','img_url','old_price','price','is_hot')
				->where('enabled','=',1);
		}
		$list = [];
		$products_count=0;
		if(!empty($products)){
			$products_count = $products->count();
			$products = $products->orderBy('title','asc')->skip($start)->take($limit)->get();

			foreach($products as $product){
				switch($product->is_hot){
					case '1':	$is_hot = 'hot'; break;
					case '2':	$is_hot = 'sale'; break;
					default:	$is_hot = '';
				}
				$list[] = [
					'id'		=> Crypt::encrypt($product->id),
					'title'		=> $product->title,
					'slug'		=> $product->slug,
					'text'		=> $product->text,
					'img_url'	=> json_decode($product->img_url),
					'old_price'	=> number_format($product->old_price, 0, '',' '),
					'price'		=> number_format($product->price, 0, '',' '),
					'is_hot'	=> $is_hot
				];
			}
		}
		$paginate_options = [
			'prev'		=> $page-1,
			'next'		=> $page+1,
			'current'	=> $page,
			'total'		=> ceil($products_count/$limit)
		];
		return view('search', [
			'defaults'		=> $defaults,
			'page_title'	=> 'Поиск',
			'products'		=> $list,
			'paginate_options'=> $paginate_options,
			'searh_request'=>$searh_request
		]);
	}
}