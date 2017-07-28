<?php
namespace App\Http\Controllers\Site;

use App\DeliveryType;
use App\Http\Controllers\Supply\Helpers;
use App\OrderStatus;
use App\Products;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class UserController extends BaseController{

	public function index(){
		$user = Auth::user();
		$defaults = Helpers::getDefaults();

		$orders_list = OrderStatus::select('id','delivery_type','history','status')->where('user_id','=',$user['id'])->orderBy('updated_at','desc')->get();
		$history = [];
		foreach($orders_list as $item){
			$products = json_decode($item->history);
			$product_list = [];

			$delivery = DeliveryType::select('price')->find($item->delivery_type);
			$total_sum = $delivery->price;
			foreach($products as $product_id => $quantity){
				$product = Products::select('title','price')->find($product_id);
				$product_list[] = $product->title;
				$total_sum += $product->price * $quantity;
			}

			switch($item->status){
				case '0':	$status = 'В процессе'; break;
				case '1':	$status = 'Выполнен'; break;
				default:	$status = 'Отменён'; break;
			}
			$history[] = [
				'vendor_code'	=> str_pad($item->id, 6, '0', STR_PAD_LEFT),
				'product_list'	=> $product_list,
				'total'			=> $total_sum,
				'status'		=> $status
			];
		}

		return view('user_panel', [
			'data'		=> [
				'name'			=> $user['name'],
				'phone'			=> $user['phone'],
				'org_caption'	=> $user['org_caption'],
				'org_tid'		=> $user['org_tid'],
				'address'		=> $user['address'],
				'correspondence'=> $user['correspondence']
			],
			'defaults'	=> $defaults,
			'history'	=> $history
		]);
	}

	public function modifyUser(Request $request){
		$data = $request->all();
		switch($data['name']){
			case 'userName':	$field = 'name'; break;
			case 'userPhone':	$field = 'phone'; break;
			case 'userOrg':		$field = 'org_caption'; break;
			case 'userOrgTID':	$field = 'org_tid'; break;
			case 'userAddr':	$field = 'address'; break;
			case 'userCorresp':	$field = 'correspondence'; break;
			default: return json_encode(['error'=>'incorrect name']);
		}
		$user = Auth::user();
		if(empty($user)){
			return json_encode(['error'=>'Для изменения данных пользователя нужна авторизация.']);
		}
		$user_data = User::where('id','=',$user['id'])->update([$field => trim($data['value'])]);
		if($user_data != false){
			return json_encode(['message'=>'success']);
		}
	}
}