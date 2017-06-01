<?php
namespace App\Http\Controllers\Admin;

use App\Brand;
use App\FooterMenu;
use App\News;
use App\Products;
use App\SocialMenu;
use App\TopMenu;
use App\User;
use App\Vacancies;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class SimilarQueriesController extends BaseController{

	public function changeEnabled(Request $request){
		$data = $request->all();
		$published = '';
		switch($data['type']){
			case 'top_menu': $result = TopMenu::where('id','=',$data['id'])->update(['enabled'=>$data['val']]); break;
			case 'footer_menu': $result = FooterMenu::where('id','=',$data['id'])->update(['enabled'=>$data['val']]); break;
			case 'news':
				$result = News::find($data['id']);
				$result->enabled = $data['val'];
				if($data['val'] > 0) {
					$result->published_at = date('Y-m-d H:i:s');
				}
				$result->save();
				$published = Functions::convertDate($result->published_at);
			break;
			case 'brands': $result = Brand::where('id','=',$data['id'])->update(['enabled'=>$data['val']]); break;
		}
		if($result != false){
			return json_encode(['message'=>'success', 'published'=>$published]);
		}
	}

	public function changePositions(Request $request){
		$data = $request->all();

		switch($data['type']){
			case 'top_menu':
				foreach($data['positions'] as $position){
					$result = TopMenu::where('id','=',$position['id'])->update(['position'=>$position['pos']]);
				}
			break;
			case 'footer_menu':
				foreach($data['positions'] as $position){
					$result = FooterMenu::where('id','=',$position['id'])->update(['position'=>$position['pos']]);
				}
			break;
			case 'brands':
				foreach($data['positions'] as $position){
					$result = Brand::where('id','=',$position['id'])->update([
						'position'=>$position['pos'],
						'refer_to'=>$position['refer']
					]);
				}
			break;
		}
		return json_encode(['message'=>'success']);
	}

	protected static function getFolders($folder = 'img', &$all_files){
		$fp=opendir($folder);
		while($cv_file=readdir($fp)) {
			if(is_file($folder."/".$cv_file)) {
				$all_files[] = $folder."/".$cv_file;
			}elseif( ($cv_file != '.') && ($cv_file != '..') && (is_dir($folder.'/'.$cv_file)) ){
				self::getFolders($folder."/".$cv_file, $all_files);
			}
		}
		closedir($fp);
		return $all_files;
	}

	public static function getAllImages($http = false){
		$folders = [];
		$folders = self::getFolders('img', $folders);

		$list = [];
		foreach($folders as $image){
			$used_in = [];

			$images = Brand::select('title')->where('img_url','LIKE','%'.$image.'%')->get();
			foreach($images as $item) $used_in['brand'][] = $item->title;

			$images = News::select('title')->where('img_url','LIKE','%'.$image.'%')->get();
			foreach($images as $item) $used_in['news'][] = $item->title;

			$images = Products::select('title')->where('img_url','LIKE','%'.$image.'%')->get();
			foreach($images as $item) $used_in['products'][] = $item->title;

			$images = SocialMenu::select('title')->where('img_url','LIKE','%'.$image.'%')->get();
			foreach($images as $item) $used_in['social'][] = $item->title;

			$images = Vacancies::select('title')->where('img_url','LIKE','%'.$image.'%')->get();
			foreach($images as $item) $used_in['vacancies'][] = $item->title;

			$list[] = [
				'img'=> (substr($image,0,1) == '/')? $image: '/'.$image,
				'used_in'=>$used_in
			];
		}
		if($http){
			return $list;
		}else{
			return json_encode([
				'message'	=> 'success',
				'images'	=> $list
			]);
		}
	}

	public function getAllImagesByRequest(){
		return self::getAllImages();
	}
}