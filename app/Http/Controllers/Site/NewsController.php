<?php
namespace App\Http\Controllers\Site;

use App\News;
use App\Pages;

use App\Http\Controllers\Supply\Helpers;
use Illuminate\Routing\Controller as BaseController;

use Auth;
use Crypt;
use Validator;

class NewsController extends BaseController{

	public function news($page = 1){
		$defaults = Helpers::getDefaults();

		$limit = 4;
		$start = ($page-1) * $limit;
		$news_count = News::where('enabled','=',1)->count();

		$news = News::select('title','slug','img_url','text')
			->where('enabled','=',1)
			->orderBy('published_at','desc')
			->skip($start)
			->take($limit)
			->get();

		$list = [];
		foreach($news as $new){
			$text_arr = explode(' ', strip_tags($new->text));
			$n = count($text_arr);
			if($n >= 32) $n = 32;
			$text = '';
			for($i = 0; $i<$n; $i++){
				$text .= $text_arr[$i].' ';
			}
			$list[] = [
				'title'		=> $new->title,
				'slug'		=> $new->slug,
				'img_url'	=> json_decode($new->img_url),
				'text'		=> $text.'&hellip;'
			];
		}
		$paginate_options = [
			'prev'		=> $page-1,
			'next'		=> $page+1,
			'current'	=> $page,
			'total'		=> ceil($news_count/$limit)
		];

		$path = \Route::current()->getName();
		$page = Pages::where('link','LIKE', '%'.$path.'%')->first();
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
		return view('news', [
			'defaults'	=> $defaults,
			'news'		=> $list,
			'paginate_options' => $paginate_options,
			'content'	=> $content,
			'meta_data'	=> $meta_data,
			'seo'		=> $seo
		]);
	}

	public function newsInner($slug){
		$defaults = Helpers::getDefaults();

		$content = News::where('slug','=',$slug)->where('enabled','=',1)->first();
		if(!empty($content)){
			$views = $content->views +1;
			News::where('slug','=',$slug)->where('enabled','=',1)->update(['views'=>$views]);
			$also_reading = News::where('also_reads','=',1)
				->where('id','!=',$content->id)
				->orderBy('published_at','desc')
				->take(3)->get();
			$list = [];
			foreach($also_reading as $new){
				$text_arr = explode(' ', strip_tags($new->text));
				$n = count($text_arr);
				if($n >= 18) $n = 18;
				$text = '';
				for($i = 0; $i<$n; $i++){
					$text .= $text_arr[$i].' ';
				}
				$list[] = [
					'title' => $new->title,
					'slug' => $new->slug,
					'img_url' => json_decode($new->img_url),
					'text' => $text.'&hellip;'
				];
			}
			return view('news_inner', [
				'defaults' => $defaults,
				'content'		=> $content,
				'also_reading'	=> $list
			]);
		}
	}
}