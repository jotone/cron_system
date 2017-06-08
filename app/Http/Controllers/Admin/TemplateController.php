<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\Template;

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
			$content = Template::orderBy('title', 'asc')->get();
			return view('admin.templates', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'content'	=> $content
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

	public function editPage($id, Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());
			$content = Template::find($id);
			return view('admin.add.templates',[
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Редактирование шаблона',
				'content'	=> $content
			]);
		}
	}

	public function addItem(Request $request){
		$data = $request->all();

		if( (isset($data['id'])) && (!empty($data['id'])) ){
			$result = Template::find($data['id']);
			$result->title	= trim($data['title']);
			$result->slug	= trim($data['slug']);
			$result->content= $data['content'];
			$result->save();
		}else{
			$result = Template::create([
				'title'		=> trim($data['title']),
				'slug'		=> trim($data['slug']),
				'content'	=> $data['content'],
			]);
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}

	public function dropItem(Request $request){
		$data = $request->all();
		$result = Template::where('id','=',$data['id'])->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}