<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Supply\Helpers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Illuminate\Support\Facades\Crypt;

class ShoppingCartController extends BaseController{

	public function index(){
		$defaults = Helpers::getDefaults();
		return view('shopping_cart', [
			'defaults' => $defaults,
		]);
	}

	public function addItem(Request $request){
		$data = $request->all();
		if(isset($data['gii'])){
			try{
				$id = Crypt::decrypt($data['gii']);

				if(isset($_COOKIE['shopping_cart'])){
					$_COOKIE['shopping_cart'] = $_COOKIE['shopping_cart'].','.$id;
					$shopping_cart = explode(',',$_COOKIE['shopping_cart']);
					$shopping_cart = array_values(array_unique($shopping_cart));
					$shopping_cart = implode(',',$shopping_cart);
					setcookie('shopping_cart',$shopping_cart, time()+36000, '/');
				}else{
					setcookie('shopping_cart',$id, time()+36000, '/');
				}
				return json_encode(['message'=>'success']);
			}catch(\Exception $e){
				var_dump($e);
			}
		}
	}
}