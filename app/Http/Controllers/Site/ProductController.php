<?php
namespace App\Http\Controllers\Site;

use App\Brand;
use App\Category;
use App\Products;

use App\Http\Controllers\Supply\Helpers;
use Illuminate\Http\Request;
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

	public function brand($brand = '', $slug = '', $page = 1){
		$defaults = Helpers::getDefaults();

		if(preg_match('/^\d+$/',$slug) > 0){
			$page = $slug;
			$brand_slug = $brand;
			$link = $brand;
		}else{
			$brand_slug = (empty($slug))? $brand: $slug;
			$link = $brand.'/'.$slug;
		}

		$brand_data = Brand::select('id','title','is_last')->where('slug','=',$brand_slug)->first();
		$inner_brands = explode(',', self::findLastBrand($brand_data));
		$inner_brands = array_diff($inner_brands, array(''));

		$products = [];
		foreach($inner_brands as $brand_id){
			$items = Products::where('refer_to_brand','=',$brand_id)
				->where('enabled','=',1)
				->get();
			foreach($items as $item){
				if(!isset($products[$item->id])){
					$products[$item->id] = [
						'title' => $item->title,
						'img_url' => json_decode($item->img_url),
						'text' => $item->text
					];
				}
			}
		}

		$limit = 6;
		$start = ($page-1) * $limit;
		$products_count = count($products);

		$products = array_slice($products, $start, $limit);

		$paginate_options = [
			'prev'		=> $page-1,
			'next'		=> $page+1,
			'current'	=> $page,
			'total'		=> ceil($products_count/$limit)
		];

		return view('brand', [
			'defaults'	=> $defaults,
			'products'	=> $products,
			'paginate_options' => $paginate_options,
			'page_title'=> $brand_data->title,
			'link'		=> $link
		]);
	}

	public function catalog(){
		$defaults = Helpers::getDefaults();
		return view('catalog', [
			'defaults' => $defaults,
		]);
	}
}