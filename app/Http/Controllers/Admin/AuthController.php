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
		dd($data);
	}
}