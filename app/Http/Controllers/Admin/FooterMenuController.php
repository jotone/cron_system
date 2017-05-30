<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\FooterMenu;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class FooterMenuController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if ($allow_access) {
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title', 'slug')->where('slug', 'LIKE', '%' . $request->path() . '%')->first();

			$menu = Functions::buildMenuList($request->path());

			$top_menu = FooterMenu::orderBy('position', 'asc')->get();
			return view('admin.footer_menu', [
				'start' => $start,
				'menu' => $menu,
				'page_title' => $page_caption->title,
				'top_menu' => $top_menu
			]);
		}
	}

	public function addPage(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			return view('admin.add.footer_menu', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Добавление меню в подвал'
			]);
		}
	}

	public function editPage($id, Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$content = FooterMenu::find($id);
			return view('admin.add.footer_menu', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Добавление меню в подвал',
				'content'	=> $content
			]);
		}
	}
	public function addItem(Request $request){
		$data = $request->all();
		$slug = Functions::str2url(trim($data['slug']));

		if( (isset($data['id'])) && (!empty($data['id'])) ){
			$result = FooterMenu::find($data['id']);
			$result->title		= trim($data['title']);
			$result->slug		= $slug;
			$result->enabled	= $data['enabled'];
			$result->is_outer	= $data['is_outer'];
			$result->save();
		}else{
			$last_obj = FooterMenu::select('position')->orderBy('position','desc')->first();
			$position = (!empty($last_obj))? $last_obj->position +1: 0;

			$result = FooterMenu::create([
				'title'		=> trim($data['title']),
				'slug'		=> $slug,
				'enabled'	=> $data['enabled'],
				'is_outer'	=> $data['is_outer'],
				'position'	=> $position
			]);
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
	public function dropItem(Request $request){
		$data = $request->all();
		$result = FooterMenu::where('id','=',$data['id'])->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}