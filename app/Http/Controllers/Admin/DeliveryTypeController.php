<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\Category;

use App\DeliveryType;
use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class DeliveryTypeController extends BaseController{
	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title','slug')->where('slug','LIKE','%'.$request->path().'%')->first();
			$menu = Functions::buildMenuList($request->path());
			$delivery = DeliveryType::orderBy('position','asc')->get();
			return view('admin.delivery', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'delivery'	=> $delivery
			]);
		}
	}

	public function addPage(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			return view('admin.add.delivery',[
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Добавление Способа Доставки',
			]);
		}
	}

	public function editPage($id, Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access) {
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			$content = DeliveryType::find($id);
			return view('admin.add.delivery',[
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> 'Редактирование Способа Доставки',
				'content'	=> $content
			]);
		}
	}

	public function addItem(Request $request){
		$data = $request->all();

		$slug = Functions::str2url(trim($data['title']));

		if( (isset($data['id'])) && (!empty($data['id'])) ){
			$result = DeliveryType::find($data['id']);
			$result->title	= trim($data['title']);
			$result->slug	= $slug;
			$result->price	= str_replace(',','.',trim($data['price']));
			$result->save();
		}else{
			$last_pos = DeliveryType::select('position')
				->orderBy('position','desc')
				->first();
			$position = (!empty($last_pos))? $last_pos->position +1: 0;
			$result = DeliveryType::create([
				'title'		=> trim($data['title']),
				'slug'		=> $slug,
				'position'	=> $position,
				'price'		=> str_replace(',','.',trim($data['price'])),
			]);
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}

	public function dropItem(Request $request){
		$data = $request->all();
		$result = DeliveryType::where('id','=',$data['id'])->delete();
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}