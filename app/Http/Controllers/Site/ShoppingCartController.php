<?php
namespace App\Http\Controllers\Site;

use App\DeliveryType;
use App\EtcData;
use App\OrderStatus;
use App\Http\Controllers\Supply\Helpers;
use App\Products;
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

		$our_email = EtcData::select('value')->where('label','=','info')->where('key','=','email')->first();
		$our_phone = EtcData::select('value')->where('label','=','info')->where('key','=','phone')->first();

		$delivery = DeliveryType::select('id','title','terms','price')->where('slug','=',$data['delivery'])->first();

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
			//to user
			$products = '';
			$shopping_cart = json_decode($_COOKIE['shopping_cart']);
			$total = 0;
			foreach($shopping_cart as $id => $q){
				$product = Products::select('title','price')->find($id);
				if(!empty($product)){
					$products .=
						'<td>'.$product->title.'</td>
						<td>'.number_format($product->price, 2, '.', ' ').' руб.</td>
						<td>'.$q.' шт.;</td>';
					$total += $product->price * $q;
				}
			}
			$message ='
			<html>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<head><title>Cron System - Ваш заказ принят</title></head>
				<body>
					<table>
						<tr>
							<td colspan="3" style="text-align: center">Уважаемый '.trim($data['lastname']).' '.trim($data['firstname']).'</td>
						</tr>
						<tr>
							<td colspan="3" style="text-align: center">Ваш заказ принят. Вы заказали:</td>
						</tr>
						<tr>'.$products.'</tr>
						<tr>
							<td>Итого:</td>
							<td colspan="2">'.$total.' руб.</td>
						</tr>
						<tr>
							<td>Доставка:</td>
							<td colspan="2">'.$delivery->title.' - '.number_format($delivery->price, 2, '.', ' ').' руб. ('.$delivery->terms.')</td>
						</tr>
						<tr>
							<td>Цена:</td>
							<td colspan="2">'.number_format($total + $delivery->price, 2, '.', ' ').' руб.</td>
						</tr>
						<tr>
							<td colspan="3">
							<p>С уважинием, администрация Cron System.</p>
							<p>e: '.$our_email->value.'</p>
							<p>t: '.$our_phone->value.'</p>
							</td>
						</tr>
					</table>
				</body>
			</html>';

			$headers  = "Content-type: text/html; charset=utf-8 \r\n";
			$headers .= 'From: <'.$our_email->value.">\r\n";

			mail($email, 'Cron System - Ваш заказ принят', $message, $headers);
			// /to user

			//to admin
			$message ='
			<html>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<head><title>Cron System - поступление заказа</title></head>
				<body>
					<table>
						<tr>
							<td colspan="3">'.trim($data['lastname']).' '.trim($data['firstname']).' ('.$email.') заказал(а) товары:</td>
						</tr>
						<tr>'.$products.'</tr>
						<tr>
							<td>На сумму:</td>
							<td colspan="2">'.$total.'</td>
						</tr>
						<tr>
							<td>Доставка:</td>
							<td colspan="2">'.$delivery->title.' - '.number_format($delivery->price, 2, '.', ' ').' руб. ('.$delivery->terms.')</td>
						</tr>
						<tr>
							<td colspan="3"><a href="http://www.cron.lar/admin">Подробнее</a></td>
						</tr>
					</table>
				</body>
			</html>';

			mail($our_email->value, 'Cron System - поступление заказа', $message, $headers);
			// /to admin

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