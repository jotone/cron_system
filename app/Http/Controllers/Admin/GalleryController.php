<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class GalleryController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title','slug')->where('slug','LIKE','%'.$request->path().'%')->first();
			$menu = Functions::buildMenuList($request->path());

			$photos = Functions::getAllImages(true);
			return view('admin.gallery', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'photos'	=> $photos
			]);
		}
	}

	public function addImage(Request $request){
		$data = $request->all();
		$error = '';
		foreach($data as $key => $value){
			if(!empty($value)){
				$image = Functions::createImg($value, true);
				if(!is_string($image)){
					$error = 'something going wrong';
				}
			}
		}
		if(empty($error)){
			return json_encode(['message' => 'success']);
		}
	}

	public function dropImage(Request $request){
		$data = $request->all();
		$path = base_path().'/public'.$data['file'];
		$result = unlink($path);
		if($result){
			return json_encode(['message' => 'success']);
		}
	}
}