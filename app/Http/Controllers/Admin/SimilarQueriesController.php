<?php
namespace App\Http\Controllers\Admin;

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
		}
		if($result != false){
			return json_encode(['message'=>'success']);
		}
	}
}