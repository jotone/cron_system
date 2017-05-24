<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\User;
use App\UserRoles;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class UserRolesController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title', 'slug')->where('slug', 'LIKE', '%' . $request->path() . '%')->first();
			$menu = Functions::buildMenuList($request->path());

			$content = UserRoles::select('*');

			$request_data = $request->all();
			$active_direction = ['sort'=>'title', 'dir'=>'asc'];

			if(isset($request_data['sort_by'])){
				$direction = ((isset($request_data['dir'])) && ($request_data['dir'] == 'asc'))? 'asc': 'desc';
				$active_direction = ['sort'=>$request_data['sort_by'], 'dir'=>$direction];
				switch($request_data['sort_by']){
					case 'title':		$content = $content->orderBy('editable','asc')->orderBy('title',$direction); break;
					case 'pseudonim':	$content = $content->orderBy('editable','asc')->orderBy('pseudonim',$direction); break;
					case 'created':		$content = $content->orderBy('editable','asc')->orderBy('created_at',$direction); break;
					case 'updated':		$content = $content->orderBy('editable','asc')->orderBy('updated_at',$direction); break;
				}
			}else{
				$content = $content->orderBy('editable','asc')->orderBy('title','asc');
			}
			$content = $content->paginate(20);

			$list = [];
			foreach($content as $item){
				if($item->access_pages == 'allow_all'){
					$pages = 'Все';
				}else{
					$pages = '';
					$temp = unserialize($item->access_pages);
					foreach($temp as $page_id){
						$page = AdminMenu::select('title')->find($page_id);
						$pages .= '<p>'.$page->title.'</p>';
					}
				}
				$list[] = [
					'id'		=> $item->id,
					'editable'	=> $item->editable,
					'title'		=> $item->title,
					'pseudonim'	=> $item->pseudonim,
					'pages'		=> $pages,
					'created'	=> Functions::convertDate($item->created_at),
					'updated'	=> Functions::convertDate($item->updated_at)
				];
			}

			$paginate_options = [
				'next_page'		=> $content->nextPageUrl().'&sort_by='.$active_direction['sort'].'&dir='.$active_direction['dir'],
				'current_page'	=> $content->currentPage(),
				'last_page'		=> $content->lastPage(),
				'sort_by'		=> $active_direction['sort'],
				'dir'			=> $active_direction['dir']
			];

			return view('admin.user_roles', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'content'	=> $list,
				'pagination'=> $paginate_options,
			]);
		}
	}
}