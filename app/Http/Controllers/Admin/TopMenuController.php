<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\TopMenu;
use App\User;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class TopMenuController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title','slug')->where('slug','LIKE','%'.$request->path().'%')->first();

			$menu = Functions::buildMenuList($request->path());

			$top_menu = TopMenu::orderBy('position','asc')->get();
			return view('admin.top_menu', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'top_menu'	=> $top_menu
			]);
		}
	}

	public function addPage(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			return view('admin.add.top_menu', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Добавление меню в Шапку'
			]);
		}
	}

	public function editPage($id, Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$content = TopMenu::find($id);
			return view('admin.add.top_menu', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Добавление меню в Шапку',
				'content'	=> $content
			]);
		}
	}
	public function addItem(Request $request){
		$data = $request->all();
		$slug = Functions::str2url(trim($data['slug']));

		if( (isset($data['id'])) && (!empty($data['id'])) ){
			$result = TopMenu::find($data['id']);
			$result->title	= trim($data['title']);
			$result->slug	= $slug;
			$result->enabled= $data['enabled'];
			$result->save();
		}else{
			$last_obj = TopMenu::select('position')->orderBy('position','desc')->first();
			$position = (!empty($last_obj))? $last_obj->position +1: 0;

			$result = TopMenu::create([
				'title'		=> trim($data['title']),
				'slug'		=> $slug,
				'enabled'	=> $data['enabled'],
				'position'	=> $position
			]);
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
	public function dropItem(Request $request){
		$data = $request->all();
		$result = TopMenu::where('id','=',$data['id'])->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}