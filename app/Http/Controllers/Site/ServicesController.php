<?php
namespace App\Http\Controllers\Site;

use App\Services;
use App\Pages;
use App\PageContent;

use App\Http\Controllers\Supply\Helpers;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
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
		$content['promo_page'] = new \DateTime($content['promo_page']);
		$current_time = new \DateTime(date('Y-m-d H:i:s'));
		$interval = $content['promo_page']->diff($current_time);

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

		$services = Services::select('title','img_url','text')
			->where('enabled','=',1)
			->orderBy('published_at','desc')
			->get();
		$list = [];
		foreach($services as $service){
			$list[] = [
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
}