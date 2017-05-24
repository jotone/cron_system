<?php
namespace App\Http\Controllers\Admin;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class HomeController extends BaseController{

	public function index(){
		return view('admin.home');
	}
}