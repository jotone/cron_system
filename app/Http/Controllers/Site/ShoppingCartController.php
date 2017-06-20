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

				if( (isset($_COOKIE['shopping_cart'])) && (!empty($_COOKIE['shopping_cart'])) ){
					$shopping_cart = json_decode($_COOKIE['shopping_cart']);
					if(isset($shopping_cart->$id)){
						$shopping_cart->$id++;
					}else{
						$shopping_cart->$id = 1;
					}
					setcookie('shopping_cart',json_encode($shopping_cart), time()+36000, '/');
				}else{
					setcookie('shopping_cart',json_encode([$id=>1]), time()+36000, '/');
				}
				return json_encode(['message'=>'success']);
			}catch(\Exception $e){
				var_dump($e);
			}
		}
	}
}