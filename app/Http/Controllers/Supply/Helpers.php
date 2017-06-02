<?php
namespace App\Http\Controllers\Supply;

use App\Brand;
use App\FooterMenu;
use App\TopMenu;
use Auth;

use Illuminate\Routing\Controller as BaseController;

class Helpers extends BaseController{
	public static function getDefaults(){
		$top_menu = TopMenu::select('title','slug')->where('enabled','=',1)->orderBy('position','asc')->get();
		$footer_menu = FooterMenu::select('title','slug','is_outer')->where('enabled','=',1)->orderBy('position','asc')->get();
		$brands = self::buildBrandList();
		return [
			'top_menu' => $top_menu,
			'footer_menu' => $footer_menu,
			'brands' => $brands
		];
	}

	public static function buildBrandList($refer_to = 0, $result = ''){
		$items = Brand::select('id','title','slug')
			->where('refer_to','=',$refer_to)
			->where('enabled','=',1)
			->orderBy('position','asc')
			->get();
		if(!empty($items->all())){
			$result .= ($refer_to == 0)? '<ul class="menu-list">': '<ul>';
			foreach($items as $item){
				$result .= '<li><a href="#'.$item->slug.'">'.$item->title.'</a>';
				$inner_count = Brand::where('refer_to','=',$item->id)->count();
				if($inner_count > 0){
					$result .= self::buildBrandList($item->id);
				}
				$result .= '</li>';
			}
			$result .= '</ul>';
		}
		return $result;
	}
}