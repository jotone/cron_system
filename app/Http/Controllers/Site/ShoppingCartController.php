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

		$product_list = Helpers::getShoppingCart();

		return view('shopping_cart', [
			'defaults'	=> $defaults,
			'items'		=> $product_list
		]);
	}

	public function addItem(Request $request){
		$data = $request->all();
		if(isset($data['gii'])){
			try{
				$id = Crypt::decrypt($data['gii']);
			}catch(\Exception $e){
				var_dump($e);
			}

			$quantity = ( (isset($data['quantity'])) && (!empty($data['quantity'])) && ctype_digit($data['quantity']) )? $data['quantity']: 1;

			if( (isset($_COOKIE['shopping_cart'])) && (!empty($_COOKIE['shopping_cart'])) ){
				$shopping_cart = json_decode($_COOKIE['shopping_cart']);
				if(isset($shopping_cart->$id)){
					$shopping_cart->$id += $quantity;
				}else{
					$shopping_cart->$id = $quantity;
				}
				setcookie('shopping_cart',json_encode($shopping_cart), time()+36000, '/');
			}else{
				setcookie('shopping_cart',json_encode([$id=>$quantity]), time()+36000, '/');
			}
			return json_encode(['message'=>'success']);
		}
	}

	public function dropItem(Request $request){
		$data = $request->all();
		try{
			$id = Crypt::decrypt($data['gii']);
		}catch(\Exception $e){
			var_dump($e);
		}
		if( (isset($_COOKIE['shopping_cart'])) && (!empty($_COOKIE['shopping_cart'])) ){
			$shopping_cart = json_decode($_COOKIE['shopping_cart']);
			unset($shopping_cart->$id);
			setcookie('shopping_cart',json_encode($shopping_cart), time()+36000, '/');
			return json_encode(['message'=>'success']);
		}
	}
}