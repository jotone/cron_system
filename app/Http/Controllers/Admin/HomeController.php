<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\Brand;
use App\DeliveryType;
use App\OrderStatus;
use App\Products;
use App\User;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class HomeController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title','slug')->where('slug','LIKE','%'.$request->path().'%')->first();
			$menu = Functions::buildMenuList($request->path());

			$orders = OrderStatus::orderBy('status','desc')->orderBy('created_at','asc')->get();

			$order_list = [
				'progress'	=>[],
				'done'		=>[],
				'canceled'	=>[]
			];

			foreach($orders as $order){
				switch($order->status){
					case '0': $type = 'progress'; break;
					case '1': $type = 'done'; break;
					default:  $type = 'canceled';
				}
				$link = ($order->user_id != 0)? route('admin-users-edit-page', $order->user_id): '';
				$delivery = DeliveryType::select('title','terms','price')->find($order->delivery_type);
				$items = json_decode($order->history);
				$products = [];
				foreach($items as $product_id => $quant){
					$product = Products::select('id','title','img_url','price','refer_to_brand','enabled')->find($product_id);
					$brand = Functions::getParentBrand($product->refer_to_brand);
					$products[] = [
						'id'		=> $product->id,
						'title'		=> $product->title,
						'brand'		=> $brand['title'],
						'price'		=> $product->price,
						'quant'		=> $quant
					];
				}

				$order_list[$type][] = [
					'id'		=> $order->id,
					'link'		=> $link,
					'user_name'	=> $order->user_lastname.' '.$order->user_firstname,
					'phone'		=> $order->phone,
					'email'		=> (!empty($order->email))? $order->email: 'Не указан',
					'address'	=> json_decode($order->address),
					'delivery'	=> $delivery->title.' - '.$delivery->price.' руб. ('.$delivery->terms.')',
					'delivery_price'=> $delivery->price,
					'products'	=> $products,
					'status'	=> $order->status,
					'created'	=> Functions::convertDate($order->created_at),
					'updated'	=> Functions::convertDate($order->updated_at),
				];
			}

			return view('admin.home', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'order_list'=> $order_list
			]);
		}
	}

	public function changeStatus(Request $request){
		$data = $request->all();
		$result = OrderStatus::where('id','=',$data['id'])->update(['status'=> $data['status']]);
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}

	public function orderDrop(Request $request){
		$data = $request->all();
		$result = OrderStatus::where('id','=',$data['id'])->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}