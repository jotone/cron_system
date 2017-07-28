<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\Brand;
use App\DeliveryType;
use App\OrderStatus;
use App\PhoneCall;
use App\Products;
use App\Questions;
use App\Services;
use App\User;

use App\Http\Controllers\Supply\Functions;
use App\UserVacancy;
use App\Vacancies;
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

			$phone_calls = PhoneCall::orderBy('status','asc')->orderBy('created_at','desc')->get();
			$call_list = [];
			foreach($phone_calls as $call){
				$service = Services::select('id','title')->find($call->info);
				switch($call->status){
					case '1':	$class = 'finished'; break;
					case '2':	$class = 'canceled'; break;
					default:	$class = '';
				}
				$call_list[] = [
					'id'		=> $call->id,
					'user_name'	=> $call->user_name,
					'phone'		=> $call->phone,
					'service'	=> [
							'id'	=>$service->id,
							'title'	=>$service->title
						],
					'class'		=> $class,
					'status'	=> $call->status,
					'created'	=> Functions::convertDate($call->created_at),
					'updated'	=> Functions::convertDate($call->updated_at),
				];
			}

			$questions = Questions::orderBy('status','asc')->orderBy('created_at','desc')->get();
			$question_list = [];
			foreach($questions as $question){
				switch($question->status){
					case '1':	$class = 'finished'; break;
					case '2':	$class = 'canceled'; break;
					default:	$class = '';
				}
				$question_list[] = [
					'id'		=> $question->id,
					'name'		=> $question->user_name,
					'organisation'=> $question->organisation,
					'city'		=> $question->city,
					'phone'		=> $question->phone,
					'type'		=> $question->callback_type,
					'email'		=> $question->email,
					'question'	=> $question->question,
					'class'		=> $class,
					'status'	=> $question->status,
					'created'	=> Functions::convertDate($question->created_at),
					'updated'	=> Functions::convertDate($question->updated_at),
				];
			}

			$vacancies = UserVacancy::orderBy('status','asc')->orderBy('created_at','desc')->get();
			$vacancy_list = [];
			foreach($vacancies as $vacancy){
				switch($vacancy->status){
					case '1':	$class = 'finished'; break;
					case '2':	$class = 'canceled'; break;
					default:	$class = '';
				}
				$current_vacancy = Vacancies::select('id','title')->find($vacancy->refer_to_vacancy);
				$vacancy_list[] = [
					'id'		=> $vacancy->id,
					'name'		=> $vacancy->name,
					'phone'		=> $vacancy->phone,
					'email'		=> $vacancy->email,
					'file'		=> substr($vacancy->file, 7),
					'vacancy'	=> [
							'id'	=> $current_vacancy->id,
							'title'	=> $current_vacancy->title
						],
					'class'		=> $class,
					'status'	=> $vacancy->status,
					'created'	=> Functions::convertDate($vacancy->created_at),
					'updated'	=> Functions::convertDate($vacancy->updated_at),
				];
			}

			return view('admin.home', [
				'start'			=> $start,
				'menu'			=> $menu,
				'page_title'	=> $page_caption->title,
				'order_list'	=> $order_list,
				'call_list'		=> $call_list,
				'question_list'	=> $question_list,
				'vacancy_list'	=> $vacancy_list
			]);
		}
	}

	public function changeStatus(Request $request){
		$data = $request->all();
		switch($data['type']){
			case 'call':	$result = PhoneCall::where('id','=',$data['id']); break;
			case 'question':$result = Questions::where('id','=',$data['id']); break;
			case 'vacancy':	$result = UserVacancy::where('id','=',$data['id']); break;
			case 'order':	$result = OrderStatus::where('id','=',$data['id']); break;
		}
		$result = $result->update(['status'=> $data['status']]);

		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}

	public function orderDrop(Request $request){
		$data = $request->all();
		switch($data['type']){
			case 'call':	$result = PhoneCall::where('id','=',$data['id']); break;
			case 'question':$result = Questions::where('id','=',$data['id']); break;
			case 'vacancy':	$result = UserVacancy::where('id','=',$data['id']); break;
			case 'order':	$result = OrderStatus::where('id','=',$data['id']); break;
		}
		$result = $result->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}