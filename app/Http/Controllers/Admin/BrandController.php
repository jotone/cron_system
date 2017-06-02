<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\Brand;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class BrandController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title','slug')->where('slug','LIKE','%'.$request->path().'%')->first();
			$menu = Functions::buildMenuList($request->path());
			$brands = Functions::buildCategoriesView('brands');

			return view('admin.brands', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'brands'	=> $brands,
			]);
		}
	}

	public function addPage(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$brands_list = Functions::buildVerticalOptionList('brands');
			return view('admin.add.brands', [
				'start'		=> $start,
				'menu'		=> $menu,
				'brands_list'=>$brands_list,
				'page_title'=> 'Добавление Брэнда'
			]);
		}
	}

	public function editPage($id, Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$content = Brand::find($id);
			$brands_list = Functions::buildVerticalOptionList('brands', $content->refer_to, $content->id);
			return view('admin.add.brands', [
				'start'		=> $start,
				'menu'		=> $menu,
				'brands_list'=>$brands_list,
				'page_title'=> 'Редактирование Брэнда',
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
			if($data['refer_to'] != 0){
				Brand::where('id','=',$data['refer_to'])->update(['is_last'=>0]);
			}
			$result = Brand::find($data['id']);
			$result->title		= trim($data['title']);
			$result->slug		= trim($data['slug']);
			$result->img_url	= $img_url;
			$result->refer_to	= $data['refer_to'];
			$result->is_last	= 1;
			$result->enabled	= $data['enabled'];
			$result->save();
		}else{
			$last_pos = Brand::select('position')
				->where('refer_to','=',$data['refer_to'])
				->orderBy('position','desc')
				->first();
			$position = (!empty($last_pos))? $last_pos->position +1: 0;
			$result = Brand::create([
				'title'		=> trim($data['title']),
				'slug'		=> trim($data['slug']),
				'img_url'	=> $img_url,
				'refer_to'	=> $data['refer_to'],
				'position'	=> $position,
				'is_last'	=> 1,
				'enabled'	=> $data['enabled']
			]);
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}

	public function dropItem(Request $request){
		$data = $request->all();

		Brand::where('refer_to','=',$data['id'])->update(['refer_to' => 0]);
		$result = Brand::where('id','=',$data['id'])->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}