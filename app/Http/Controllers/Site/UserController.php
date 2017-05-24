<?php
namespace App\Http\Controllers\Site;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class UserController extends BaseController{

	public function index(){
	    $user = Auth::user();
	    dd($user);
		return view('user_panel');
	}
}