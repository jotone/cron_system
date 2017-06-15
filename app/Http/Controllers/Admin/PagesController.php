<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;

use App\Http\Controllers\Supply\Functions;
use App\PageContent;
use App\Pages;
use App\Template;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class PagesController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title', 'slug')->where('slug', 'LIKE', '%' . $request->path() . '%')->first();

			$menu = Functions::buildMenuList($request->path());

			$pages = Pages::select('id','title','link','content','used_template','created_at','updated_at')->get();

			$list = [];
			foreach($pages as $page){
				$content = json_decode($page->content);
				$image = '';
				foreach($content as $content_id){
					$page_content = PageContent::select('meta_value')->find($content_id);
					$res = preg_match('/img":".+?"/', $page_content->meta_value, $matches);
					if($res > 0){
						$image = str_replace('\\','',substr($matches[0], 6,-1));
						break;
					}
				}

				$template = Template::select('title')->find($page->used_template);
				$list[] = [
					'id'		=> $page->id,
					'title'		=> $page->title,
					'link'		=> $page->link,
					'img_url'	=> $image,
					'template'	=> $template->title,
					'created_at'=> Functions::convertDate($page->created_at),
					'updated_at'=> Functions::convertDate($page->updated_at),
				];
			}

			return view('admin.pages', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'content'	=> [],
				'pages'		=> $list
			]);
		}
	}

	public function addPage(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());


			$templates = Template::orderBy('title','asc')->get();
			return view('admin.add.pages',[
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Добавление страницы',
				'templates'	=> $templates,
			]);
		}
	}

	public function editPage($id, Request $request){}

	public function addItem(Request $request){
		$data = $request->all();

		if($data['need_seo'] == 1){
			$seo_title = $data['seo_title'];
			$seo_text = $data['seo_text'];
		}else{
			$seo_title = $seo_text = '';
		}
		$temp_content = json_decode($data['content']);

		$content = [];
		foreach($temp_content as $pos => $item){
			$content[$pos]['type'] = $item->type;
			switch($item->type){
				case 'block':
					foreach($item->value as $inner_pos => $value){
						switch($value->type){
							case 'single-image':
								if($data['image_type'.$value->name] == 'file'){
									$image = [
										'img'=>$data['image'.$value->name],
										'alt'=>$data['image_alt'.$value->name]
									];
								}else{
									$img_url = Functions::createImg($data['image_'.$value->name], true);
									$image = [
										'img'=>$img_url,
										'alt'=>$data['image_alt'.$value->name]
									];
								}
								$content[$pos][$item->name][$value->name] = [
									'type'	=> $value->type,
									'value'	=> $image
								];
							break;

							case 'string':
							case 'text':
								$content[$pos][$item->name][$value->field] = [
									'type'	=> $value->type,
									'value'	=> $value->value
								];
							break;
						}
					}
				break;

				case 'drop_down':
					$content[$pos][$item->name] = [
						'type'	=> $item->type,
						'value'	=> $item->value
					];
				break;

				case 'single-image':
					if($data['image_type'.$item->name] == 'file'){
						$image = [
							'img'=>$data['image'.$item->name],
							'alt'=>$data['image_alt'.$item->name]
						];
					}else{
						$img_url = Functions::createImg($data['image_'.$item->name], true);
						$image = [
							'img'=>$img_url,
							'alt'=>$data['image_alt'.$item->name]
						];
					}
					$content[$pos][$item->name] = [
						'type'	=> $item->type,
						'value'	=> $image
					];
				break;

				case 'slider':
					$result_slider = [];
					foreach($item->value as $slide_pos => $slide){
						if(!empty($slide->uploaded)){
							foreach($data as $key => $val){
								if((strpos($key, $item->name) === 0) && ($key != $item->name) && (!empty($val)) && ($val != 'undefined')){
									if ($val->getClientOriginalName() == $slide->uploaded) {
										$result_slider[$slide->pos] = [
											'alt' => $slide->alt,
											'img' => Functions::createImg($val)
										];
									}
								}
							}
						}elseif(!empty($slide->image)){
							$result_slider[$slide->pos] = [
								'alt' => $slide->alt,
								'img' => $slide->image
							];
						}
					}
					$content[$pos][$item->name] = [
						'type'	=> $item->type,
						'value'	=> $result_slider
					];
				break;

				case 'text':
					$content[$pos][$item->field] = [
						'type'	=> $item->type,
						'value'	=> $item->value
					];
				break;
			}
		}

		if((isset($data['id'])) && (!empty($data['id']))){
			$result = Pages::find($data['id']);
			$result->title			= trim($data['title']);
			$result->link			= trim($data['link']);
			$result->content		= '';
			$result->meta_title		= trim($data['meta_title']);
			$result->meta_keywords	= trim($data['meta_keywords']);
			$result->meta_description= trim($data['meta_description']);
			$result->need_seo		= $data['need_seo'];
			$result->seo_title		= $seo_title;
			$result->seo_text		= $seo_text;
			$result->used_template	= $data['used_template'];
			$result->save();
		}else{
			$content_ids = [];
			foreach($content as $item){
				$page_content = [
					'type'		=> $item['type'],
					'meta_key'	=> '',
					'meta_value'=> ''
				];
				foreach($item as $field_name => $field_value){
					if($field_name != 'type'){
						$page_content['meta_key'] = $field_name;
						$page_content['meta_value']=json_encode($field_value);
					}
				}
				$result = PageContent::create($page_content);
				$content_ids[] = $result->id;
			}
			$result = Pages::create([
				'title'			=> trim($data['title']),
				'link'			=> trim($data['link']),
				'content'		=> json_encode($content_ids),
				'meta_title'	=> trim($data['meta_title']),
				'meta_keywords'	=> trim($data['meta_keywords']),
				'meta_description'=> trim($data['meta_description']),
				'need_seo'		=> $data['need_seo'],
				'seo_title'		=> $seo_title,
				'seo_text'		=> $seo_text,
				'used_template'	=> $data['used_template']
			]);
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}

	public function dropItem(Request $request){
		$data = $request->all();

		$result = Pages::select('content')->find($data['id']);
		$result = json_decode($result->content);
		foreach($result as $content_id){
			PageContent::where('id','=',$content_id)->delete();
		}
		$result = Pages::where('id','=',$data['id'])->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}