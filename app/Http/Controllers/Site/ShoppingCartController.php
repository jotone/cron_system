<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Supply\Helpers;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;

class ShoppingCartController extends BaseController{

	public function index(){
		$defaults = Helpers::getDefaults();
		return view('shopping_cart', [
			'defaults' => $defaults,
		]);
	}
}