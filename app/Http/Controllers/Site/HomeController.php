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

class HomeController extends BaseController{

	public function index(){
		$top_menu = TopMenu::select('title','slug')->where('enabled','=',1)->orderBy('position','asc')->get();
		$footer_menu = FooterMenu::select('title','slug','is_outer')->where('enabled','=',1)->orderBy('position','asc')->get();
		return view('home', [
			'top_menu' => $top_menu,
			'footer_menu' => $footer_menu
		]);
	}
}