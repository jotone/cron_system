<?php
namespace App\Http\Controllers\Site;

use App\Vacancies;

use App\Http\Controllers\Supply\Helpers;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class VacanciesController extends BaseController{

	public function vacancies($page = 1){
		$defaults = Helpers::getDefaults();

		$limit = 6;
		$start = ($page-1) * $limit;
		$vacancies_count = Vacancies::where('enabled','=',1)->count();

		$vacancies = Vacancies::select('title','slug','img_url','text')
			->where('enabled','=',1)
			->orderBy('published_at','desc')
			->skip($start)
			->take($limit)
			->get();

		$list = [];
		foreach($vacancies as $vacancy){
			$text_arr = explode(' ', strip_tags($vacancy->text));
			$n = count($text_arr);
			if($n >= 32) $n = 32;
			$text = '';
			for($i = 0; $i<$n; $i++){
				$text .= $text_arr[$i].' ';
			}
			$list[] = [
				'title'		=> $vacancy->title,
				'slug'		=> $vacancy->slug,
				'img_url'	=> json_decode($vacancy->img_url),
				'text'		=> $text.'&hellip;'
			];
		}
		$paginate_options = [
			'prev'		=> $page-1,
			'next'		=> $page+1,
			'current'	=> $page,
			'total'		=> ceil($vacancies_count/$limit)
		];
		return view('vacancies', [
			'defaults'	=> $defaults,
			'vacancies'	=> $list,
			'paginate_options' => $paginate_options
		]);
	}

	public function vacanciesInner($slug){
		$defaults = Helpers::getDefaults();

		$content = Vacancies::select('title','text','img_url','meta_title','meta_description','meta_keywords','views')
			->where('slug','=',$slug)
			->where('enabled','=',1)
			->first();
		if(!empty($content)){
			$views = $content->views +1;
			Vacancies::where('slug','=',$slug)->update(['views'=>$views]);

			return view('vacancies_inner', [
				'defaults'	=> $defaults,
				'meta_title'=> $content->meta_title,
				'meta_description' => $content->meta_description,
				'meta_keywords' => $content->meta_keywords,
				'content'	=> [
					'title'		=> $content->title,
					'text'		=> $content->text,
					'img_url'	=> json_decode($content->img_url),
				],
			]);
		}
	}
}