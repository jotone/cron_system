<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;

use App\Http\Controllers\Supply\Functions;
use App\News;
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

			return view('admin.pages', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'content'	=> [],
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
								$content[$pos][$item->name][$inner_pos][$value->name] = [
									'type'	=> $value->type,
									'value'	=> $image
								];
							break;

							case 'string':
							case 'text':
								$content[$pos][$item->name][$inner_pos][$value->field] = [
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
			$result->content		= json_encode($content);
			$result->meta_title		= trim($data['meta_title']);
			$result->meta_keywords	= trim($data['meta_keywords']);
			$result->meta_description= trim($data['meta_description']);
			$result->need_seo		= $data['need_seo'];
			$result->seo_title		= $seo_title;
			$result->seo_text		= $seo_text;
			$result->used_template	= $data['used_template'];
			$result->save();
		}else{
			$result = Pages::create([
				'title'			=> trim($data['title']),
				'link'			=> trim($data['link']),
				'content'		=> json_encode($content),
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

	public function dropItem(Request $request){}
}