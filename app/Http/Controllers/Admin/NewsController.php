<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\News;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class NewsController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title','slug')->where('slug','LIKE','%'.$request->path().'%')->first();

			$menu = Functions::buildMenuList($request->path());

			$news = News::orderBy('published_at','desc')->get();
			$list = [];
			foreach($news as $new){
				$list[] = [
					'id'		=>$new->id,
					'title'		=>$new->title,
					'img_url'	=>json_decode($new->img_url),
					'views'		=>$new->views,
					'enabled'	=>$new->enabled,
					'published_at'=>Functions::convertDate($new->published_at),
					'created_at'=>Functions::convertDate($new->created_at),
					'updated_at'=>Functions::convertDate($new->updated_at),
				];
			}
			return view('admin.news', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'content'	=> $list
			]);
		}
	}

	public function addPage(Request $request){}

	public function editPage($id, Request $request){}

	public function addItem(Request $request){}
	public function dropItem(Request $request){}
}