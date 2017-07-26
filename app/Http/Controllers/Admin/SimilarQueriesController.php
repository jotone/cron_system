<?php
namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Category;
use App\DeliveryType;
use App\FooterMenu;
use App\News;
use App\Products;
use App\Services;
use App\TopMenu;
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
			case 'brands': $result = Brand::where('id','=',$data['id'])->update(['enabled'=>$data['val']]); break;
			case 'categories': $result = Category::where('id','=',$data['id'])->update(['enabled'=>$data['val']]); break;
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
			case 'products':
				$result = Products::find($data['id']);
				$result->enabled = $data['val'];
				if($data['val'] > 0) {
					$result->published_at = date('Y-m-d H:i:s');
				}
				$result->save();
				$published = Functions::convertDate($result->published_at);
			break;
			case 'services':
				$result = Services::find($data['id']);
				$result->enabled = $data['val'];
				if($data['val'] > 0) {
					$result->published_at = date('Y-m-d H:i:s');
				}
				$result->save();
				$published = Functions::convertDate($result->published_at);
			break;
			case 'top_menu': $result = TopMenu::where('id','=',$data['id'])->update(['enabled'=>$data['val']]); break;
			case 'vacancies':
				$result = Vacancies::find($data['id']);
				$result->enabled = $data['val'];
				if($data['val'] > 0) {
					$result->published_at = date('Y-m-d H:i:s');
				}
				$result->save();
				$published = Functions::convertDate($result->published_at);
			break;
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
					TopMenu::where('id','=',$position['id'])->update(['position'=>$position['pos']]);
				}
			break;
			case 'footer_menu':
				foreach($data['positions'] as $position){
					FooterMenu::where('id','=',$position['id'])->update(['position'=>$position['pos']]);
				}
			break;
			case 'brands':
				foreach($data['positions'] as $position){
					Brand::where('id','=',$position['id'])->update([
						'position'=>$position['pos'],
						'refer_to'=>$position['refer'],
						'is_last' => 1
					]);
					Brand::where('id','=',$position['refer'])->update(['is_last'=>0]);
				}
			break;
			case 'categories':
				foreach($data['positions'] as $position){
					Category::where('id','=',$position['id'])->update(['position'=>$position['pos']]);
				}
			break;
			case 'delivery':
				foreach($data['positions'] as $position){
					DeliveryType::where('id','=',$position['id'])->update(['position'=>$position['pos']]);
				}
			break;
		}
		return json_encode(['message'=>'success']);
	}
}