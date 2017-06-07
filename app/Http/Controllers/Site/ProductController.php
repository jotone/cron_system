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

	public function brand($brand = '', $slug = '', $page = 1, $per = 6){
		$defaults = Helpers::getDefaults();

		if(preg_match('/^\d+$/',$slug) > 0){
			$page = $slug;
			$brand_slug = $brand;
			$link = $brand;
		}else{
			$brand_slug = (empty($slug))? $brand: $slug;
			$link = $brand.'/'.$slug;
		}

		$brand_data = Brand::select('id','title','slug','is_last')->where('slug','=',$brand_slug)->first();
		$inner_brands = explode(',', self::findLastBrand($brand_data));
		$inner_brands = array_diff($inner_brands, array(''));

		$products = [];
		foreach($inner_brands as $brand_id){
			$items = Products::select('id','title','slug','img_url','text','price','old_price','is_hot')
				->where('refer_to_brand','=',$brand_id)
				->where('enabled','=',1)
				->get();
			foreach($items as $item){
				if(!isset($products[$item->id])){
					switch($item->is_hot){
						case '1': $is_hot = 'hot'; break;
						case '2': $is_hot = 'sale'; break;
						default: $is_hot = '';
					}
					$products[$item->id] = [
						'title'		=> $item->title,
						'slug'		=> $item->slug,
						'img_url'	=> json_decode($item->img_url),
						'text'		=> $item->text,
						'price'		=> $item->price,
						'old_price'	=> $item->old_price,
						'is_hot'	=> $is_hot
					];
				}
			}
		}
		$products = array_values($products);

		$limit = $per;
		$start = ($page-1) * $limit;
		$products_count = count($products);

		$products_list = $products;
		usort($products_list, function($a, $b){
			return strcmp($a['title'], $b['title']);
		});

		$products = array_slice($products, $start, $limit);

		$paginate_options = [
			'prev'		=> $page-1,
			'next'		=> $page+1,
			'current'	=> $page,
			'total'		=> ceil($products_count/$limit)
		];

		return view('brand', [
			'defaults'		=> $defaults,
			'products'		=> $products,
			'paginate_options'=> $paginate_options,
			'page_title'	=> $brand_data->title,
			'link'			=> $link,
			'products_list'	=> $products_list
		]);
	}

	public function catalog(){
		$defaults = Helpers::getDefaults();
		return view('catalog', [
			'defaults' => $defaults,
		]);
	}
}