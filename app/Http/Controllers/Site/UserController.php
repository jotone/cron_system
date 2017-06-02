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
		$defaults = Helpers::getDefaults();

		return view('user_panel', [
			'data' => [
				'name'			=> $user['name'],
				'phone'			=> $user['phone'],
				'org_caption'	=> $user['org_caption'],
				'org_tid'		=> $user['org_tid'],
				'address'		=> $user['address'],
				'correspondence'=> $user['correspondence']
			],
			'defaults' => $defaults,
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