<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\Brand;
use App\Category;
use App\Products;

use App\Http\Controllers\Supply\Functions;
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
				$content = $content->orderBy('created_at','desc');
			}
			$content = $content->paginate(20);

			$list = [];
			foreach($content as $product){
				$category = Category::select('title')->find($product->refer_to_category);
				$brand = Brand::select('title')->find($product->refer_to_brand);
				$list[] = [
					'id'		=> $product->id,
					'title'		=> $product->title,
					'img_url'	=> json_decode($product->img_url),
					'price'		=> number_format($product->price, 2, '.', ' '),
					'category'	=> $category,
					'brand'		=> $brand,
					'rating'	=> $product->rating,
					'is_hot'	=> $product->is_hot,
					'views'		=> $product->views,
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

			$brands_list = Functions::buildVerticalOptionList('brands');
			$categories_list = Functions::buildVerticalOptionList('categories');

			return view('admin.add.products',[
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Добавление товара',
				'brands'	=> $brands_list,
				'categories'=> $categories_list
			]);
		}
	}
	public function editPage($id, Request $request){}
	public function addItem(Request $request){}
	public function dropItem(Request $request){}
}