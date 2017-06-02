<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\EtcData;

use App\Http\Controllers\Supply\Functions;
use App\SocialMenu;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class ContactsController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title','slug')->where('slug','LIKE','%'.$request->path().'%')->first();
			$menu = Functions::buildMenuList($request->path());

			$content = EtcData::where('label','=','info')->get();

			$social = SocialMenu::orderBy('position','asc')->get();
			$list = ['social'=>[
				'title'	=> 'Социальные Сети',
				'val'	=> $social
			]];
			foreach ($content as $item) {
				switch($item->key){
					case 'marker_coordinates': $value = json_decode($item->value); break;
					default: $value = $item->value;
				}
				$list[$item->key] = [
					'title'	=> $item->title,
					'val'	=> $value
				];
			}
			//dd($list);
			return view('admin.info', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'content'	=> $list
			]);
		}
	}
}