<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\Category;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class CategoryController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title','slug')->where('slug','LIKE','%'.$request->path().'%')->first();
			$menu = Functions::buildMenuList($request->path());
			$categories = Functions::buildCategoriesView('categories');
			return view('admin.categories', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'categories'=> $categories
			]);
		}
	}

	public function addPage(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			return view('admin.add.categories', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Добавление категории'
			]);
		}
	}

	public function editPage($id, Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$content = Category::find($id);
			return view('admin.add.categories', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Редатирование категории',
				'content'	=> $content
			]);
		}
	}

	public function addItem(Request $request){
		$data = $request->all();

		$slug = Functions::str2url(trim($data['slug']));

		if( (isset($data['id'])) && (!empty($data['id'])) ){
			$result = Category::find($data['id']);
			$result->title	= trim($data['title']);
			$result->slug	= $slug;
			$result->enabled= $data['enabled'];
			$result->save();
		}else{
			$last_pos = Category::select('position')
				->orderBy('position','desc')
				->first();
			$position = (!empty($last_pos))? $last_pos->position +1: 0;
			$result = Category::create([
				'title'		=> trim($data['title']),
				'slug'		=> $slug,
				'position'	=> $position,
				'enabled'	=> $data['enabled']
			]);
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}

	public function dropItem(Request $request){
		$data = $request->all();

		$result = Category::where('id','=',$data['id'])->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}