<?php
namespace App\Http\Controllers\Site;

use App\EtcData;
use App\News;
use App\Pages;
use App\PageContent;

use App\Http\Controllers\Supply\Helpers;
use App\Products;
use App\Questions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Validator;

class HomeController extends BaseController{

	public function index(Request $request){
		$defaults = Helpers::getDefaults();

		$page = Pages::where('link','=',$request->path())->first();
		$content = [];
		if(!empty($page)){
			$page_content = json_decode($page->content);
			foreach ($page_content as $item) {
				$temp = PageContent::select('meta_key','meta_value')->find($item);
				$content[$temp->meta_key] = json_decode($temp->meta_value);
			}
		}

		$meta_data = [
			'title'		=> $page->meta_title,
			'keywords'	=> $page->meta_keywords,
			'description' => $page->meta_description
		];

		if(isset($content['news'])){
			$news = [];
			foreach($content['news']->value as $news_id){
				$new = News::select('title','slug','text','img_url')->find($news_id);

				$text_arr = explode(' ', strip_tags($new->text));
				$n = count($text_arr);
				if($n >= 17) $n = 17;
				$text = '';
				for($i = 0; $i<$n; $i++){
					$text .= $text_arr[$i].' ';
				}
				$news[] = [
					'title'		=> $new->title,
					'slug'		=> $new->slug,
					'img_url'	=> json_decode($new->img_url),
					'text'		=> $text.'&hellip;'
				];
			}
			$content['news'] = $news;
		}

		$products = Products::select('id','title','slug','text','img_url','old_price','price','is_hot')
			->where('enabled','=',1)
			->where('show_on_main','=',1)
			->orderBy('published_at','desc')
			->skip(0)
			->take(8)
			->get();
		$product_list = [];

		foreach($products as $product){
			switch($product->is_hot){
				case '1':	$is_hot = 'hot'; break;
				case '2':	$is_hot = 'sale'; break;
				default:	$is_hot = '';
			}
			$product_list[] = [
				'id'		=> Crypt::encrypt($product->id),
				'title'		=> $product->title,
				'slug'		=> $product->slug,
				'img_url'	=> json_decode($product->img_url),
				'text'		=> $product->text,
				'price'		=> number_format($product->price, 0, '',' '),
				'old_price'	=> number_format($product->old_price, 0, '',' '),
				'is_hot'	=> $is_hot,
			];
		}
		$content['products'] = $product_list;

		return view('home', [
			'defaults'	=> $defaults,
			'content'	=> $content,
			'meta_data'	=> $meta_data
		]);
	}

	public function aboutUs(Request $request){
		$defaults = Helpers::getDefaults();

		$page = Pages::where('link','LIKE', '%'.$request->path().'%')->first();
		$content = [];
		if(!empty($page)){
			$page_content = json_decode($page->content);
			foreach ($page_content as $item) {
				$temp = PageContent::select('meta_key','meta_value')->find($item);
				$content[$temp->meta_key] = json_decode($temp->meta_value);
			}
		}

		$meta_data = [
			'title'		=> $page->meta_title,
			'keywords'	=> $page->meta_keywords,
			'description' => $page->meta_description
		];

		$seo = [
			'need_seo'	=> $page->need_seo,
			'title'		=> $page->seo_title,
			'text'		=> $page->seo_text
		];

		return view('about_us', [
			'defaults'	=> $defaults,
			'allow_map'	=> true,
			'content'	=> $content,
			'meta_data'	=> $meta_data,
			'seo'		=> $seo
		]);
	}

	public function contacts(Request $request){
		$defaults = Helpers::getDefaults();

		$page = Pages::where('link','LIKE', '%'.$request->path().'%')->first();
		$content = [];
		if(!empty($page)){
			$page_content = json_decode($page->content);
			foreach ($page_content as $item) {
				$temp = PageContent::select('meta_key','meta_value')->find($item);
				$content[$temp->meta_key] = json_decode($temp->meta_value);
			}
		}

		$meta_data = [
			'title'		=> $page->meta_title,
			'keywords'	=> $page->meta_keywords,
			'description' => $page->meta_description
		];

		$seo = [
			'need_seo'	=> $page->need_seo,
			'title'		=> $page->seo_title,
			'text'		=> $page->seo_text
		];

		return view('contacts', [
			'defaults'	=> $defaults,
			'allow_map'	=> true,
			'content'	=> $content,
			'meta_data'	=> $meta_data,
			'seo'		=> $seo
		]);
	}

	public function equipment(Request $request){
		$defaults = Helpers::getDefaults();

		$page = Pages::where('link','LIKE', '%'.$request->path().'%')->first();
		$content = [];
		if(!empty($page)){
			$page_content = json_decode($page->content);
			foreach ($page_content as $item) {
				$temp = PageContent::select('meta_key','meta_value')->find($item);
				$content[$temp->meta_key] = json_decode($temp->meta_value);
			}
		}

		$meta_data = [
			'title'		=> $page->meta_title,
			'keywords'	=> $page->meta_keywords,
			'description' => $page->meta_description
		];

		$seo = [
			'need_seo'	=> $page->need_seo,
			'title'		=> $page->seo_title,
			'text'		=> $page->seo_text
		];

		return view('equipment', [
			'defaults' => $defaults,
			'content'	=> $content,
			'meta_data'	=> $meta_data,
			'seo'		=> $seo
		]);
	}

	public function request(){
		$defaults = Helpers::getDefaults();
		return view('request', [
			'defaults' => $defaults,
		]);
	}

	public function getMoreProducts(Request $request){
		$data = $request->all();
		if( (isset($data['start'])) && (ctype_digit($data['start'])) ){
			$start = $data['start'];
						$count=$data['loadCount'];
			$products = Products::select('id','title','slug','text','img_url','old_price','price','is_hot')
				->where('enabled','=',1)
				->where('show_on_main','=',1)
				->orderBy('published_at','desc')
				->skip($start)
				->take($count)
				->get();
			$product_list = [];

			foreach($products as $product){
				switch($product->is_hot){
					case '1':	$is_hot = 'hot'; break;
					case '2':	$is_hot = 'sale'; break;
					default:	$is_hot = '';
				}
				$product_list[] = [
					'id'		=> $product->id,
					'title'		=> $product->title,
					'slug'		=> $product->slug,
					'img_url'	=> json_decode($product->img_url),
					'text'		=> $product->text,
					'price'		=> $product->price,
					'old_price'	=> $product->old_price,
					'is_hot'	=> $is_hot,
					'formated_price'	=> number_format($product->price, 0, '',' '),
					'formated_old_price'=> number_format($product->old_price, 0, '',' '),
				];
			}

			$next_products = Products::select('id')
				->where('enabled','=',1)
				->where('show_on_main','=',1)
				->orderBy('published_at','desc')
				->count();
						$has_more=($next_products-$start-$count+1>0)?1:0;
			if(!empty($product_list)){
				return json_encode([
					'message'	=> 'success',
					'has_more'	=> $has_more,
					'items'		=> $product_list,
					'start'		=> $start
				]);
			}else{
				return json_encode([
					'message'	=> 'empty_data'
				]);
			}
		}
	}

	public function askQuestion(Request $request){
		$data = $request->all();

		if(isset($data['callbackType'])){
			switch(trim($data['callbackType'])){
				case 0:
				case '0': $call_back_type = 'Хочу, чтобы менеджер ответил мне по E-mail'; break;

				case 1:
				case '1': $call_back_type = 'Хочу, чтобы менеджер мне перезвонил'; break;

				case 2:
				case '2': $call_back_type = 'Хочу, чтобы менеджер приехал на встречу'; break;
				default: $call_back_type = '';
			}
		}

		$result = Questions::create([
			'user_name'		=> trim($data['name']),
			'organisation'	=> trim($data['organisation']),
			'city'			=> trim($data['city']),
			'phone'			=> trim($data['tel']),
			'callback_type'	=> $call_back_type,
			'email'			=> trim($data['email']),
			'question'		=> trim($data['question'])
		]);

		if($result != false){
			$our_email = EtcData::select('value')->where('label','=','info')->where('key','=','email')->first();
			$our_phone = EtcData::select('value')->where('label','=','info')->where('key','=','phone')->first();
			//to user
			$message ='
			<html>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<head><title>Cron System - Ваш вопрос принят</title></head>
				<body>
					<table>
						<tr>
							<td>Уважаемый '.trim($data['name']).', Ваш вопрос "'.trim($data['question']).'" получен, и в скором времени мы с Вами свяжемся.</td>
						</tr>
						<tr>
							<td>
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

			mail(trim($data['email']), 'Cron System - Ваш вопрос получен', $message, $headers);
			// /to user

			//to admin
			$message ='
			<html>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<head><title>Cron System - Поступил вопрос</title></head>
				<body>
					<table>
						<tr><td>Поступил вопрос</td></tr>
						<tr>
							<td>
								<p>От: '.trim($data['name']).'</p>
								<p>Организация: '.trim($data['organisation']).'</p>
								<p>Город: '.trim($data['city']).'</p>
								<p>Телефон: '.trim($data['tel']).'</p>
								<p>email: '.trim($data['email']).'</p>
							</td>
						</tr>
						<tr>
							<td>
								<p>Суть вопроса: '.trim($data['question']).'</p><br>
								<p>Примечание: '.trim($data['callbackType']).'</p>
							</td>
						</tr>
						<tr><td><a href="'.\URL::asset('/admin/').'">Подробнее</a></td>
							
						</tr>
					</table>
				</body>
			</html>';
			mail($our_email->value, 'Cron System - Поступил вопрос', $message, $headers);
			// /to admin
			return json_encode([
				'message'=>'success',
				'request'=>'ask_question'
			]);
		}
	}
}