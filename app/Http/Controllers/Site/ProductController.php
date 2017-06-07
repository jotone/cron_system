<?php
namespace App\Http\Controllers\Site;

use App\Brand;
use App\Category;
use App\Http\Controllers\Supply\Helpers;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class ProductController extends BaseController{
	protected static function findLastBrand($brand_data){
		$result = '';
		if($brand_data->is_last < 1){
			$sub_brands = Brand::select('id','is_last')->where('refer_to','=',$brand_data->id)->get();
			foreach($sub_brands as $sub_brand){
				$result .= self::findLastBrand($sub_brand);
			}
		}else{
			$result = $brand_data->id.',';
		}
		return $result;
	}

	public function brand($brand = '', $slug = ''){
		$defaults = Helpers::getDefaults();
		$brand_slug = (empty($slug))? $brand: $slug;
		$brand_data = Brand::select('id','title','is_last')->where('slug','=',$brand_slug)->first();
		$inner_brands = explode(',', self::findLastBrand($brand_data));
		$inner_brands = array_diff($inner_brands, array(''));

		dd($inner_brands);

		return view('brand', [
			'defaults' => $defaults,
		]);
	}

	public function catalog(){
		$defaults = Helpers::getDefaults();
		return view('catalog', [
			'defaults' => $defaults,
		]);
	}
}