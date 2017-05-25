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
				if($item->editable > 0){
					if($item->access_pages == 'allow_all'){
						$pages = 'Все';
					}else{
						$pages = '';
						$temp = json_decode($item->access_pages);
						foreach($temp as $page_id){
							$page = AdminMenu::select('title')->find($page_id);
							$pages .= '<p>'.$page->title.'</p>';
						}
					}
					$users = User::select('email')->where('role','=',$item->pseudonim)->get();
					$users_list = '';
					foreach($users as $user){
						$users_list .= '<p>'.$user->email.'</p>';
					}
					$list[] = [
						'id'		=> $item->id,
						'title'		=> $item->title,
						'pseudonim'	=> $item->pseudonim,
						'pages'		=> $pages,
						'users'		=> $users_list,
						'created'	=> Functions::convertDate($item->created_at),
						'updated'	=> Functions::convertDate($item->updated_at)
					];
				}
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

	public function addPage(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$pages = AdminMenu::select('id','title')->orderBy('title','asc')->get();

			return view('admin.add.user_roles',[
				'start' => $start,
				'menu' => $menu,
				'page_title' => 'Добавление роли пользователя',
				'pages' => $pages
			]);
		}
	}

	public function editPage($id, Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$pages = AdminMenu::select('id','title')->orderBy('title','asc')->get();
			$content = UserRoles::find($id);
			return view('admin.add.user_roles',[
				'start' => $start,
				'menu' => $menu,
				'page_title' => 'Добавление роли пользователя',
				'pages' => $pages,
				'content' => $content
			]);
		}
	}

	public function addItem(Request $request){
		$data = $request->all();
		if( (isset($data['id'])) && (!empty($data['id'])) ){
			$result = UserRoles::find($data['id']);
			$result->title		= trim($data['title']);
			$result->pseudonim	= trim($data['pseudonim']);
			$result->access_pages = $data['pages'];
			$result->save();
		}else{
			$result = UserRoles::create([
				'title'		=> trim($data['title']),
				'pseudonim'	=> trim($data['pseudonim']),
				'editable'	=> 1,
				'access_pages' => $data['pages']
			]);
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}

	public function dropItem(Request $request){
		$data = $request->all();

		$user_role = UserRoles::select('pseudonim')->find($data['id']);
		User::where('role','=',$user_role->pseudonim)->update(['role' => '']);

		$user_role = UserRoles::where('id','=',$data['id'])->delete();
		if($user_role != false){
			return json_encode(['message'=>'success']);
		}
	}
}