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

	public function news(){
		$top_menu = TopMenu::select('title','slug')->where('enabled','=',1)->orderBy('position','asc')->get();
		$footer_menu = FooterMenu::select('title','slug','is_outer')->where('enabled','=',1)->orderBy('position','asc')->get();

		$news = News::orderBy('published_at','desc')->get();
		dd($news);
		return view('news', [
			'top_menu'		=> $top_menu,
			'footer_menu'	=> $footer_menu
		]);
	}

	public function newsInner($slug){
		$top_menu = TopMenu::select('title','slug')->where('enabled','=',1)->orderBy('position','asc')->get();
		$footer_menu = FooterMenu::select('title','slug','is_outer')->where('enabled','=',1)->orderBy('position','asc')->get();
		return view('news_inner', [
			'top_menu'		=> $top_menu,
			'footer_menu'	=> $footer_menu
		]);
	}
}