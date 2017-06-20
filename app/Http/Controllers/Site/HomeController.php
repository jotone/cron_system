<?php
namespace App\Http\Controllers\Site;

use App\News;
use App\Pages;
use App\PageContent;

use App\Http\Controllers\Supply\Helpers;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
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
			->orderBy('published_at','asc')
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
				'id'		=> $product->id,
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

	public function contacts(){
		$defaults = Helpers::getDefaults();
		return view('contacts', [
			'defaults' => $defaults,
			'allow_map'		=>true
		]);
	}

	public function equipment(){
		$defaults = Helpers::getDefaults();
		return view('equipment', [
			'defaults' => $defaults,
		]);
	}

	public function request(){
		$defaults = Helpers::getDefaults();
		return view('request', [
			'defaults' => $defaults,
		]);
	}

	public function services(){
		$defaults = Helpers::getDefaults();
		return view('services', [
			'defaults' => $defaults,
		]);
	}

	public function thanks(){
		$defaults = Helpers::getDefaults();
		return view('thanks', [
			'defaults' => $defaults,
		]);
	}

	public function getMoreProducts(Request $request){
		$data = $request->all();
		if( (isset($data['start'])) && (ctype_digit($data['start'])) ){
			$start = $data['start']+8;
			$products = Products::select('id','title','slug','text','img_url','old_price','price','is_hot')
				->where('enabled','=',1)
				->where('show_on_main','=',1)
				->orderBy('published_at','asc')
				->skip($start)
				->take(4)
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

			if(!empty($product_list)){
				return json_encode([
					'message'	=> 'success',
					'has_more'	=> $next_products-$start-8,
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
}