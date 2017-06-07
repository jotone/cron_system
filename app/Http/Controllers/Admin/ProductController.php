<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\Brand;
use App\Category;
use App\Products;

use App\Http\Controllers\Supply\Functions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class ProductController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title', 'slug')->where('slug', 'LIKE', '%' . $request->path() . '%')->first();

			$menu = Functions::buildMenuList($request->path());

			$content = Products::select('id','title','img_url','price','refer_to_category','refer_to_brand','rating','is_hot','enabled','published_at','created_at','updated_at');

			$request_data = $request->all();
			$active_direction = ['sort'=>'title', 'dir'=>'asc'];

			if(isset($request_data['sort_by'])){
				$direction = ((isset($request_data['dir'])) && ($request_data['dir'] == 'asc'))? 'asc': 'desc';
				$active_direction = ['sort'=>$request_data['sort_by'], 'dir'=>$direction];
				switch($request_data['sort_by']){
					case 'title':		$content = $content->orderBy('title',$direction); break;
					case 'price':		$content = $content->orderBy('price',$direction); break;
					case 'category':	$content = $content->orderBy('refer_to_category',$direction); break;
					case 'brand':		$content = $content->orderBy('refer_to_brand',$direction); break;
					case 'rating':		$content = $content->orderBy('refer_to_brand',$direction); break;
					case 'is_hot':		$content = $content->orderBy('is_hot',$direction); break;
					case 'published':	$content = $content->orderBy('enabled',$direction)->orderBy('published_at',$direction); break;
					case 'created':		$content = $content->orderBy('created_at',$direction); break;
					case 'updated':		$content = $content->orderBy('updated_at',$direction); break;
				}
			}else{
				$content = $content->orderBy('title','asc');
			}
			$content = $content->paginate(20);

			$list = [];
			foreach($content as $product){
				$category = Category::select('title')->find($product->refer_to_category);
				$brand = Brand::select('title')->find($product->refer_to_brand);
				switch($product->is_hot){
					case '0': $is_hot = 'Не назначено'; break;
					case '1': $is_hot = '<div class="hot">HOT</div>'; break;
					case '2': $is_hot = '<div class="sale">SALE</div>'; break;
				}
				$list[] = [
					'id'		=> $product->id,
					'title'		=> $product->title,
					'img_url'	=> json_decode($product->img_url),
					'price'		=> number_format($product->price, 2, '.', ' '),
					'category'	=> $category->title,
					'brand'		=> $brand->title,
					'rating'	=> $product->rating,
					'is_hot'	=> $is_hot,
					'enabled'	=> ($product->enabled == 1)? 'checked="checked"': '',
					'published_at'=>Functions::convertDate($product->published_at),
					'created_at'=> Functions::convertDate($product->created_at),
					'updated_at'=> Functions::convertDate($product->updated_at),
				];
			}

			$paginate_options = [
				'next_page'		=> $content->nextPageUrl().'&sort_by='.$active_direction['sort'].'&dir='.$active_direction['dir'],
				'current_page'	=> $content->currentPage(),
				'last_page'		=> $content->lastPage(),
				'sort_by'		=> $active_direction['sort'],
				'dir'			=> $active_direction['dir']
			];
			return view('admin.products', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'content'	=> $list,
				'pagination'=> $paginate_options,
			]);
		}
	}

	public function addPage(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$brands_list = Brand::where('is_last','=',1)->select('id','title')->orderBy('title','asc')->get();
			$categories_list = Category::select('id','title')->orderBy('title','asc')->get();

			return view('admin.add.products',[
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Добавление товара',
				'brands'	=> $brands_list,
				'categories'=> $categories_list
			]);
		}
	}

	public function editPage($id, Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$content = Products::find($id);
			$brands_list = Brand::where('is_last','=',1)->select('id','title')->orderBy('title','asc')->get();
			$categories_list = Category::select('id','title')->orderBy('title','asc')->get();

			return view('admin.add.products',[
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Редактирование товара',
				'content'	=> $content,
				'brands'	=> $brands_list,
				'categories'=> $categories_list
			]);
		}
	}

	public function addItem(Request $request){
		$data = $request->all();

		if($data['image_type'] == 'file'){
			$img_url = json_encode([
				'img'=>$data['image'],
				'alt'=>$data['image_alt']
			]);
		}else{
			$image = Functions::createImg($data['image'], true);
			$img_url = json_encode([
				'img'=>$image,
				'alt'=>$data['image_alt']
			]);
		}
		if( (isset($data['id'])) && (!empty($data['id'])) ){
			$result = Products::find($data['id']);
			$result->title				= trim($data['title']);
			$result->slug				= trim($data['slug']);
			$result->text				= $data['text'];
			$result->img_url			= $img_url;
			$result->old_price			= str_replace(',','.',$data['old_price']);
			$result->price				= str_replace(',','.',$data['price']);
			$result->refer_to_category	= $data['category'];
			$result->refer_to_brand		= $data['brand'];
			$result->rating				= ( ($data['rating'] == 'undefined') || ($data['rating'] == '') )? 0: $data['rating'];
			$result->is_hot				= $data['is_hot'];
			$result->enabled			= $data['enabled'];
			if($result->enabled > 0){
				$result->published_at = date('Y-m-d H:i:s');
			}
			$result->save();
		}else{
			$result = Products::create([
				'title'				=> trim($data['title']),
				'slug'				=> trim($data['slug']),
				'text'				=> $data['text'],
				'img_url'			=> $img_url,
				'old_price'			=> str_replace(',','.',$data['old_price']),
				'price'				=> str_replace(',','.',$data['price']),
				'refer_to_category'	=> $data['category'],
				'refer_to_brand'	=> $data['brand'],
				'rating'			=> ( ($data['rating'] == 'undefined') || ($data['rating'] == '') )? 0: $data['rating'],
				'is_hot'			=> $data['is_hot'],
				'views'				=> 0,
				'enabled'			=> $data['enabled'],
				'published_at'		=> date('Y-m-d H:i:s')
			]);
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}

	public function dropItem(Request $request){
		$data = $request->all();
		$result = Products::where('id','=',$data['id'])->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}