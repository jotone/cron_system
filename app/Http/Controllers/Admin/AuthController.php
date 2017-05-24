<?php
namespace App\Http\Controllers\Admin;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class AuthController extends BaseController{

	public function loginPage(){
		return view('admin.login');
	}

	public function login(Request $request){
		$data = $request->all();
		$data['email'] = trim($data['email']);
		$data['pass'] = trim($data['password']);
		$password = md5($data['email'].$data['password']);
		$user = User::select('id','role')->where('email','=',$data['email'])->where('password','=',$password)->first();

		if(empty($user)){
			return redirect(route('home'));
		}
		if(empty($user->role)){
			return redirect(route('home'));
		}
		$auth = Auth::loginUsingId($user->id);
		if(!$auth){
			return redirect(route('home'));
		}
		return redirect(route('admin-index'));
	}
}