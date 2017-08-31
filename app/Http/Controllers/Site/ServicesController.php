<?php
namespace App\Http\Controllers\Site;

use App\PhoneCall;
use App\Services;
use App\Pages;
use App\PageContent;

use App\Http\Controllers\Supply\Helpers;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use League\Flysystem\Exception;
use Validator;

class ServicesController extends BaseController{
	public function services(Request $request){
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
		$interval = new \DateTime($content['promo_page']);
				$interval=$interval->format('Y-m-d H:i:s');
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

		$services = Services::select('id','title','img_url','text')
			->where('enabled','=',1)
			->orderBy('published_at','desc')
			->get();
		$list = [];
		foreach($services as $service){
			$list[] = [
				'id'		=> Crypt::encrypt($service->id),
				'title'		=> $service->title,
				'img_url'	=> json_decode($service->img_url),
				'text'		=> $service->text
			];
		}

		return view('services', [
			'defaults'	=> $defaults,
			'services'	=> $list,
			'interval'	=> $interval,
			'meta_data'	=> $meta_data,
			'seo'		=> $seo
		]);
	}

	public function orderPhoneCall(Request $request){
		$data = $request->all();

		try{
			$service_id = Crypt::decrypt($data['service']);
		}catch(Exception $e){
			return json_encode($e);
		}

		$result = PhoneCall::create([
			'user_name'	=> trim($data['name']),
			'phone'		=> trim($data['tel']),
			'info'		=> $service_id
		]);

		if($result != false){
			//to admin
			$our_email = EtcData::select('value')->where('label','=','info')->where('key','=','email')->first();

			$message ='
			<html>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<head><title>Cron System - принят запрос на обратный звонок</title></head>
				<body>
					<table>
						<tr>
							<td>Принят запрос на обратный звонок</td>
						</tr>
						<tr>
							<td>Имя: '.trim($data['name']).'</td>
						</tr>
						<tr>
							<td>Телефон: '.trim($data['phone']).'</td>
						</tr>
						<tr>
							<td><a href="http://www.cron.lar/admin">Подробнее</a></td>
						</tr>
					</table>
				</body>
			</html>';
			$headers  = "Content-type: text/html; charset=utf-8 \r\n";
			$headers .= 'From: <'.$our_email->value.">\r\n";

			mail($our_email->value, 'Cron System - принят запрос на обратный звонок', $message, $headers);
			// /to admin
			return json_encode([
				'message'=>'success',
				'request'=>'order_phone_call'
			]);
		}
	}
}