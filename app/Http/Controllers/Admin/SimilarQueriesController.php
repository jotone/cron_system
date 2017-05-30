<?php
namespace App\Http\Controllers\Admin;

use App\FooterMenu;
use App\TopMenu;
use App\User;

use App\Http\Controllers\Supply\Functions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class SimilarQueriesController extends BaseController{

	public function changeEnabled(Request $request){
		$data = $request->all();
		switch($data['type']){
			case 'top_menu': $result = TopMenu::where('id','=',$data['id'])->update(['enabled'=>$data['val']]); break;
			case 'footer_menu': $result = FooterMenu::where('id','=',$data['id'])->update(['enabled'=>$data['val']]); break;
		}
		if($result != false){
			return json_encode(['message'=>'success']);
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
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
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

	public function getAllImages(){
		$folders = [];
		$folders = self::getFolders('img', $folders);

		

		return json_encode([
			'message' => 'success',
			'folders' => $folders
		]);
	}
}