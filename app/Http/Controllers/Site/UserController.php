<?php
namespace App\Http\Controllers\Site;

use App\FooterMenu;
use App\TopMenu;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class UserController extends BaseController{

	public function index(){
		$user = Auth::user();
		$top_menu = TopMenu::select('title','slug')->where('enabled','=',1)->orderBy('position','asc')->get();
		$footer_menu = FooterMenu::select('title','slug','is_outer')->where('enabled','=',1)->orderBy('position','asc')->get();

		return view('user_panel', [
			'data' => [
				'name'			=> $user['name'],
				'phone'			=> $user['phone'],
				'org_caption'	=> $user['org_caption'],
				'org_tid'		=> $user['org_tid'],
				'address'		=> $user['address'],
				'correspondence'=> $user['correspondence']
			],
			'top_menu'		=> $top_menu,
			'footer_menu'	=> $footer_menu
		]);
	}

	public function modifyUser(Request $request){
		$data = $request->all();
		switch($data['name']){
			case 'userName':	$field = 'name'; break;
			case 'userPhone':	$field = 'phone'; break;
			case 'userOrg':		$field = 'org_caption'; break;
			case 'userOrgTID':	$field = 'org_tid'; break;
			case 'userAddr':	$field = 'address'; break;
			case 'userCorresp':	$field = 'correspondence'; break;
			default: return json_encode(['error'=>'incorrect name']);
		}
		$user = Auth::user();
		if(empty($user)){
			return json_encode(['error'=>'Для изменения данных пользователя нужна авторизация.']);
		}
		$user_data = User::where('id','=',$user['id'])->update([$field => trim($data['value'])]);
		if($user_data != false){
			return json_encode(['message'=>'success']);
		}
	}
}