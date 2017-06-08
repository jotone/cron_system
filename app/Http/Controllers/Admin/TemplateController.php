<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class TemplateController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title', 'slug')->where('slug', 'LIKE', '%' . $request->path() . '%')->first();

			$menu = Functions::buildMenuList($request->path());

			return view('admin.templates', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'content'	=> [],
			]);
		}
	}

	public function addPage(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			return view('admin.add.templates',[
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Добавление шаблона',
			]);
		}
	}

	public function editPage($id, Request $request){}

	public function addItem(Request $request){}

	public function dropItem(Request $request){}
}