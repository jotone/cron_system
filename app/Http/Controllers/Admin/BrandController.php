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

	public function importPage(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$data = $request->all();
			$start = Functions::getMicrotime();
			$menu = Functions::buildMenuList($request->path());

			return view('admin.import.brands', [
				'start'		=> $start,
				'menu'		=> $menu,
				'data'		=> $data
			]);
		}
	}

	//Import_controlls
	public function importCSV(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			switch ($_REQUEST['action']){
				case 'to_json':
					$data = $request->all();
					$row = 1;
					$res=array();
					$fh = fopen($_FILES['file_brands']['tmp_name'], "r");
					if (($handle = $fh) !== FALSE) {
						while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
							$num = count($data);
							$row++;
							$tmp_arr=array();
							for ($c=0; $c < $num; $c++) {
								$tmp_arr[]= $data[$c];
							}
							$res[]=$tmp_arr;
						}
						fclose($handle);
					}
					$res=['error'=>'0', 'message'=>'success','data'=>$res];
					return json_encode($res,JSON_UNESCAPED_UNICODE);
				break;
				case 'add_list':
					$result= Functions::addBrandList($_REQUEST['json']);
					return json_encode($res=['error'=>'0', 'message'=>$result],JSON_UNESCAPED_UNICODE);
				break;
			}
		}
		return json_encode(['error'=>'1', 'message'=>'No elements find!']);
	}

	public function import_list(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			//Импортирование одной цепочки брендов
		}
	}
	//END Import_controlls

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

		if($data['refer_to'] != 0){
			Brand::where('id','=',$data['refer_to'])->update(['is_last'=>0]);
		}

		if( (isset($data['id'])) && (!empty($data['id'])) ){
			$result = Brand::find($data['id']);
			$result->title		= trim($data['title']);
			$result->slug		= trim($data['slug']);
			$result->need_seo	= $data['need_seo'];
			$result->seo_title	= $data['seo_title'];
			$result->seo_text	= $data['seo_text'];
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
				'refer_to'	=> $data['refer_to'],
				'position'	=> $position,
				'need_seo'	=> $data['need_seo'],
				'seo_title'	=> $data['seo_title'],
				'seo_text'	=> $data['seo_text'],
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