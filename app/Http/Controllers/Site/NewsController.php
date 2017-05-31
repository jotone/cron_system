<?php
namespace App\Http\Controllers\Site;

use App\FooterMenu;
use App\TopMenu;
use App\News;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class NewsController extends BaseController{

	public function news($page = 1){
		$top_menu = TopMenu::select('title','slug')->where('enabled','=',1)->orderBy('position','asc')->get();
		$footer_menu = FooterMenu::select('title','slug','is_outer')->where('enabled','=',1)->orderBy('position','asc')->get();

		$limit = 4;
		$start = ($page-1) * $limit;
		$news_count = News::where('enabled','=',1)->count();

		$news = News::where('enabled','=',1)->orderBy('published_at','desc')->skip($start)->take($limit)->get();

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
				'id'=>$new->id,
				'title' => $new->title,
				'slug' => $new->slug,
				'img_url' => json_decode($new->img_url),
				'text' => $text.'&hellip;'
			];
		}
		$paginate_options = [
			'prev'		=> $page-1,
			'next'		=> $page+1,
			'current'	=> $page,
			'total'		=> ceil($news_count/$limit)
		];
		return view('news', [
			'top_menu'		=> $top_menu,
			'footer_menu'	=> $footer_menu,
			'news'			=> $list,
			'paginate_options' => $paginate_options
		]);
	}

	public function newsInner($slug){
		dd($slug);
		$top_menu = TopMenu::select('title','slug')->where('enabled','=',1)->orderBy('position','asc')->get();
		$footer_menu = FooterMenu::select('title','slug','is_outer')->where('enabled','=',1)->orderBy('position','asc')->get();
		return view('news_inner', [
			'top_menu'		=> $top_menu,
			'footer_menu'	=> $footer_menu
		]);
	}
}