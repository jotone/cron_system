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

			$content = News::select('id','title','img_url','views','enabled','published_at','created_at','updated_at');

			$request_data = $request->all();
			$active_direction = ['sort'=>'title', 'dir'=>'asc'];

			if(isset($request_data['sort_by'])){
				$direction = ((isset($request_data['dir'])) && ($request_data['dir'] == 'asc'))? 'asc': 'desc';
				$active_direction = ['sort'=>$request_data['sort_by'], 'dir'=>$direction];
				switch($request_data['sort_by']){
					case 'title':		$content = $content->orderBy('title',$direction); break;
					case 'views':		$content = $content->orderBy('views',$direction); break;
					case 'enabled':		$content = $content->orderBy('enabled',$direction)->orderBy('published_at',$direction); break;
					case 'created':		$content = $content->orderBy('created_at',$direction); break;
					case 'updated':		$content = $content->orderBy('updated_at',$direction); break;
				}
			}else{
				$content = $content->orderBy('created','desc');
			}
			$content = $content->paginate(20);

			$list = [];
			foreach($content as $new){
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

			$paginate_options = [
				'next_page'		=> $content->nextPageUrl().'&sort_by='.$active_direction['sort'].'&dir='.$active_direction['dir'],
				'current_page'	=> $content->currentPage(),
				'last_page'		=> $content->lastPage(),
				'sort_by'		=> $active_direction['sort'],
				'dir'			=> $active_direction['dir']
			];
			return view('admin.news', [
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

			return view('admin.add.news',[
				'start' => $start,
				'menu' => $menu,
				'page_title' => 'Добавление новости',
			]);
		}
	}

	public function editPage($id, Request $request){}

	public function addItem(Request $request){}
	public function dropItem(Request $request){}
}