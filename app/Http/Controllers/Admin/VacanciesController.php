<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\Vacancies;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class VacanciesController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title','slug')->where('slug','LIKE','%'.$request->path().'%')->first();

			$menu = Functions::buildMenuList($request->path());

			$content = Vacancies::select('*');

			$request_data = $request->all();
			$active_direction = ['sort'=>'title', 'dir'=>'asc'];

			if(isset($request_data['sort_by'])){
				$direction = ((isset($request_data['dir'])) && ($request_data['dir'] == 'asc'))? 'asc': 'desc';
				$active_direction = ['sort'=>$request_data['sort_by'], 'dir'=>$direction];
				switch($request_data['sort_by']){
					case 'title':		$content = $content->orderBy('title',$direction); break;
					case 'slug':		$content = $content->orderBy('slug',$direction); break;
					case 'views':		$content = $content->orderBy('views',$direction); break;
					case 'published':	$content = $content->orderBy('enabled',$direction)->orderBy('published_at',$direction); break;
					case 'created':		$content = $content->orderBy('created_at',$direction); break;
					case 'updated':		$content = $content->orderBy('updated_at',$direction); break;
				}
			}else{
				$content = $content->orderBy('title','asc');
			}
			$content = $content->paginate(20);

			$list = [];
			foreach($content as $new){
				$list[] = [
					'id'		=> $new->id,
					'title'		=> $new->title,
					'slug'		=> $new->slug,
					'img_url'	=> json_decode($new->img_url),
					'views'		=> $new->views,
					'enabled'	=> ($new->enabled == 1)? 'checked="checked"': '',
					'published_at'=>Functions::convertDate($new->published_at),
					'created_at'=> Functions::convertDate($new->created_at),
					'updated_at'=> Functions::convertDate($new->updated_at),
				];
			}

			$paginate_options = [
				'next_page'		=> $content->nextPageUrl().'&sort_by='.$active_direction['sort'].'&dir='.$active_direction['dir'],
				'current_page'	=> $content->currentPage(),
				'last_page'		=> $content->lastPage(),
				'sort_by'		=> $active_direction['sort'],
				'dir'			=> $active_direction['dir']
			];
			return view('admin.vacancies', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'content'	=> $list,
				'pagination'=> $paginate_options,
			]);
		}
	}

	public function addPage(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			return view('admin.add.vacancies',[
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Добавление вакансии',
			]);
		}
	}

	public function editPage($id, Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$content = Vacancies::find($id);
			return view('admin.add.vacancies',[
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Редактирование вакансии',
				'content'	=> $content
			]);
		}
	}

	public function addItem(Request $request){
		$data = $request->all();
		if($data['image_type'] == 'file'){
			$img_url = json_encode([
				'img'=>$data['image'],
				'alt'=>$data['image_alt']
			]);
		}else{
			$image = Functions::createImg($data['image'], true);
			$img_url = json_encode([
				'img'=>$image,
				'alt'=>$data['image_alt']
			]);
		}
		if( (isset($data['id'])) && (!empty($data['id'])) ){
			$result = Vacancies::find($data['id']);
			$result->title			= trim($data['title']);
			$result->slug			= trim($data['slug']);
			$result->text			= $data['text'];
			$result->img_url		= $img_url;
			$result->enabled		= $data['enabled'];
			$result->meta_title		= $data['meta_title'];
			$result->meta_keywords	= $data['meta_keywords'];
			$result->meta_description = $data['meta_description'];
			if($result->enabled > 0){
				$result->published_at = date('Y-m-d H:i:s');
			}
			$result->save();
		}else{
			$result = Vacancies::create([
				'title'			=> trim($data['title']),
				'slug'			=> trim($data['slug']),
				'text'			=> $data['text'],
				'img_url'		=> $img_url,
				'enabled'		=> $data['enabled'],
				'meta_title'	=> $data['meta_title'],
				'meta_keywords'	=> $data['meta_keywords'],
				'meta_description' => $data['meta_description'],
				'views'			=> 0,
				'published_at'	=> date('Y-m-d H:i:s')
			]);
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}

	public function dropItem(Request $request){
		$data = $request->all();
		$result = Vacancies::where('id','=',$data['id'])->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}