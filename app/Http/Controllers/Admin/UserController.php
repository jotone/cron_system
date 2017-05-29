<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\User;

use App\Http\Controllers\Supply\Functions;
use App\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class UserController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title', 'slug')->where('slug', 'LIKE', '%' . $request->path() . '%')->first();
			$menu = Functions::buildMenuList($request->path());

			$content = User::select('id','name','email','phone','role','activated','created_at','updated_at');

			$request_data = $request->all();
			$active_direction = ['sort'=>'title', 'dir'=>'asc'];

			if(isset($request_data['sort_by'])){
				$direction = ((isset($request_data['dir'])) && ($request_data['dir'] == 'asc'))? 'asc': 'desc';
				$active_direction = ['sort'=>$request_data['sort_by'], 'dir'=>$direction];
				switch($request_data['sort_by']){
					case 'email':		$content = $content->orderBy('email',$direction); break;
					case 'name':		$content = $content->orderBy('name',$direction); break;
					case 'phone':		$content = $content->orderBy('phone',$direction); break;
					case 'role':		$content = $content->orderBy('role',$direction); break;
					case 'activated':	$content = $content->orderBy('activated',$direction); break;
					case 'created':		$content = $content->orderBy('created_at',$direction); break;
					case 'updated':		$content = $content->orderBy('updated_at',$direction); break;
				}
			}else{
				$content = $content->orderBy('email','asc');
			}
			$content = $content->paginate(20);

			$list = [];
			foreach($content as $item){
				if(!empty($item->role)){
					$role = UserRoles::select('title')->where('pseudonim', '=', $item->role)->first();
					$role = $role->title;
				}else{
					$role = 'Пользователь';
				}
				$list[] = [
					'id'		=> $item->id,
					'email'		=> $item->email,
					'name'		=> $item->name,
					'phone'		=> $item->phone,
					'role'		=> $role,
					'activated'	=> ($item->activated == 1)? 'Активирован': 'Не активирован',
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
			return view('admin.users', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'content'	=> $list,
				'pagination'=> $paginate_options,
			]);
		}
	}

	public function editPage($id, Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$roles = UserRoles::select('title','pseudonim')->orderBy('title','asc')->get();
			$content = User::find($id);
			return view('admin.add.users',[
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Редактирование пользователя',
				'content'	=> $content,
				'roles'		=> $roles
			]);
		}
	}

	public function editItem(Request $request){
		$data = $request->all();
		$user = Auth::user();
		//dd($data);
		$user_changes_password = false;

		if( (isset($data['id'])) && (!empty($data['id'])) ){
			if( ($user['role'] != 'ADM_ROLE') && ($data['role'] == 'ADM_ROLE') ){
				return json_encode(['message'=>'error', 'text'=>'Недостаточно прав для назначения данной роли пользователя.']);
			}
			if(!empty(trim($data['password']))){
				$fail = Validator::make($data, [
					'password'			=> 'required|min:6',
					'confirm_password'	=> 'required|same:password'
				]);
				if($fail->fails()){
					return json_encode(['message'=>'error', 'text'=>'Пароль не подтвержден.']);
				}
				$user_changes_password = true;
			}
			$user_isset = User::select('id')->where('email','=',trim($data['email']))->first();
			if($user_isset->id != $data['id']){
				return json_encode(['message'=>'error', 'text'=>'Такой пользователь уже существует.']);
			}

			$result = User::find($data['id']);
			$result->email			= trim($data['email']);
			$result->name			= trim($data['name']);
			$result->phone			= trim($data['phone']);
			$result->org_caption	= trim($data['org_caption']);
			$result->org_tid		= trim($data['org_tid']);
			$result->address		= trim($data['address']);
			$result->correspondence	= trim($data['correspondence']);

			if($data['role'] != '0'){
				$result->role		= $data['role'];
			}
			if(isset($data['activated'])){
				$result->activated	= $data['activated'];
			}
			if($user_changes_password){
				$password = md5(trim($data['email']).trim($data['password']));
				$result->password	= $password;
			}
			$result->save();
			if($result != false){
				return json_encode(['message'=>'success']);
			}
		}
	}

	public function dropItem(Request $request){
		$data = $request->all();
		$user = Auth::user();
		$user_data = User::find($data['id']);
		if( ($user['role'] != 'ADM_ROLE') && ($user_data->role == 'ADM_ROLE') ){
			return json_encode(['message'=>'error', 'text'=>'Недостаточно прав для удаления данного пользователя.']);
		}
		$result = User::where('id','=',$data['id'])->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}