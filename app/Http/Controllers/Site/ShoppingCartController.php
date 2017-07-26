<?php
namespace App\Http\Controllers\Site;

use App\DeliveryType;
use App\OrderStatus;
use App\Http\Controllers\Supply\Helpers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Illuminate\Support\Facades\Crypt;

class ShoppingCartController extends BaseController{

	public function index(){
		$defaults = Helpers::getDefaults();
		$product_list = Helpers::getShoppingCart();
		$delivery = DeliveryType::select('title','slug','price','terms')->orderBy('position','asc')->get();
		return view('shopping_cart', [
			'defaults'	=> $defaults,
			'items'		=> $product_list,
			'delivery'	=> $delivery
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

	public function checkout(Request $request){
		$data = $request->all();

		$user = Auth::user();
		$user_id = (!$user)? 0: $user['id'];
		$email = (!isset($data['email']))? '': trim($data['email']);

		$delivery = DeliveryType::select('id')->where('slug','=',$data['delivery'])->first();

		$result = OrderStatus::create([
			'user_id'		=> $user_id,
			'user_firstname'=> trim($data['firstname']),
			'user_lastname'	=> trim($data['lastname']),
			'phone'			=> trim($data['phone']),
			'email'			=> $email,
			'address'		=> json_encode([
				'c'=> trim($data['country']),
				'r'=> trim($data['region']),
				't'=> trim($data['city']),
				'a'=> trim($data['address']),
				'i'=> trim($data['index'])
			]),
			'delivery_type'	=> $delivery->id,
			'history'		=> $_COOKIE['shopping_cart'],
			'status'		=> 0
		]);

		if($result != false){
			if(isset($_COOKIE['shopping_cart'])){
				unset($_COOKIE['shopping_cart']);
				setcookie('shopping_cart', null, -3600);
			}
			$defaults = Helpers::getDefaults();
			return view('thanks', [
				'defaults' => $defaults,
			]);
		}
	}

	public function updateCart(Request $request){
		$data = $request->all();
		$shopping_cart = [];
		foreach($data['values'] as $item){
			$shopping_cart[Crypt::decrypt($item['gii'])] = $item['q'];
		}
		setcookie('shopping_cart',json_encode($shopping_cart), time()+36000, '/');
		return json_encode(['message'=>'success']);
	}
}