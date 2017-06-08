<?php
namespace App\Http\Controllers\Site;

use App\Brand;
use App\Category;
use App\Products;

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

	protected static function findLastBrandWithProducts($parent_brand_id, $result = []){
		$inner_brands = Brand::select('id','title','slug','is_last')->where('refer_to','=',$parent_brand_id)->get();
		foreach($inner_brands as $brand_data){
			if($brand_data->is_last == 1){
				$brand_products_count = Products::where('refer_to_brand','=',$brand_data->id)->count();
				if($brand_products_count > 0){
					$result[] = [
						'title'	=> $brand_data->title,
						'slug'	=> $brand_data->slug,
					];
				}
			}else{
				$temp = self::findLastBrandWithProducts($brand_data->id);
				foreach($temp as $item) $result[] = $item;
			}
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
						'price'		=> number_format($item->price, 0, '',' '),
						'old_price'	=> number_format($item->old_price, 0, '',' '),
						'is_hot'	=> $is_hot,
					];
				}
			}
		}
		$products = array_values($products);

		$limit = (isset($_COOKIE['per_page']))? $_COOKIE['per_page']: 8;
		if($limit < 2) $limit = 8;
		$start = ($page-1) * $limit;
		$products_count = count($products);
		$products = array_slice($products, $start, $limit);

		$parent_brand = Brand::select('id')->where('slug','=',$brand)->first();
		$products_list = self::findLastBrandWithProducts($parent_brand->id);
		usort($products_list, function($a, $b){
			return strcmp($a['title'], $b['title']);
		});

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
			'products_list'	=> $products_list,
			'parent_brand'	=> $brand,
			'limit'			=> $limit,
		]);
	}

	public function catalog(){
		$defaults = Helpers::getDefaults();
		return view('catalog', [
			'defaults' => $defaults,
		]);
	}
}