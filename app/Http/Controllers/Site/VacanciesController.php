<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Supply\Functions;
use App\Pages;
use App\UserVacancy;
use App\Vacancies;

use Illuminate\Http\Request;
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

		return view('vacancies', [
			'defaults'	=> $defaults,
			'vacancies'	=> $list,
			'paginate_options' => $paginate_options,
			'content'	=> $content,
			'meta_data'	=> $meta_data,
			'seo'		=> $seo
		]);
	}

	public function vacanciesInner($slug){
		$defaults = Helpers::getDefaults();

		$content = Vacancies::select('id','title','text','img_url','meta_title','meta_description','meta_keywords','views')
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
					'id'		=> Crypt::encrypt($content->id),
					'text'		=> $content->text,
					'img_url'	=> json_decode($content->img_url),
				],
			]);
		}
	}

	public function sendResume(Request $request){
		$data = $request->all();

		if( ('undefined' != $data['file']) && (!empty($data['file'][0])) ){
			$destinationPath = base_path().'/public/documents/';
			try{
				$file = pathinfo(Functions::str2url($data['file'][0]->getClientOriginalName()));
			}catch(\Exception $e){
				return redirect()->route('vacancies-inner', $data['vacancy'])->withErrors(['Неверный формат файла.']);
			}
			$mime_type = mime_content_type($data['file'][0]->getRealPath());

			$file['extension'] = strtolower($file['extension']);
			switch($file['extension']){
				case 'doc':
				case 'docx':
				case 'ods':
				case 'odt':
				case 'pdf':
				case 'sxc':
				case 'sxw':
				case 'rtf':
				case 'xls':
				case 'xlsx':
				case 'xml':
					$allow_by_extension = true;
				break;
				default:
					return json_encode(['message'=>'error','text'=>'Неверный формат файла.']);
			}

			switch($mime_type){
				case 'application/msword':
				case 'application/pdf':
				case 'application/rtf':
				case 'application/xml':
				case 'application/vnd.ms-excel':
				case 'application/application/vnd.oasis.opendocument.spreadsheet':
				case 'application/vnd.oasis.opendocument.text':
				case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
				case 'application/octet-stream':
					$allow_by_mime = true;
				break;
				default:
					return json_encode(['message'=>'error','text'=>'Неверный формат файла.']);
			}

			if(($allow_by_extension) && ($allow_by_mime)){
				$data['file'][0]->move($destinationPath, $file['basename']);

				$result = UserVacancy::create([
					'name'		=> trim($data['name']),
					'phone'		=> trim($data['tel']),
					'email'		=> trim($data['email']),
					'file'		=> '/public/documents/'.$file['basename'],
					'status'	=> 0,
					'refer_to_vacancy' => $data['vacancy'],
				]);
				if($result != false){
					return json_encode(['message'=>'success']);
				}
			}
		}else{
			return json_encode(['message'=>'error','text'=>'Прикрепите файл резюме.']);
		}
	}
}