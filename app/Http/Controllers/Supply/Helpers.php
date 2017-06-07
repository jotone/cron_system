<?php
namespace App\Http\Controllers\Supply;

use App\Brand;
use App\FooterMenu;
use Illuminate\Http\Request;
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

	public static function buildBrandList($refer_to = 0, $parent = '', $result = ''){
		$items = Brand::select('id','title','slug')
			->where('refer_to','=',$refer_to)
			->where('enabled','=',1)
			->orderBy('position','asc')
			->get();
		if(!empty($items->all())){

			$n = count($items);
			if($refer_to == 0) {
				$result .= '<ul class="menu-list">';
			}else{
				$result .= ($n > 15)? '<div>': '<ul>';
			}

			for($i = 0; $i<$n; $i++){
				if($refer_to == 0){
					$parent = $items[$i]->slug.'/';
					$link = $items[$i]->slug;
				}else{
					$link = $parent.$items[$i]->slug;
				}

				if( (count($items) > 15) && ($i%15 == 0) )
					$result .= '<ul>';

				$inner_count = Brand::where('refer_to','=',$items[$i]->id)->count();
				$wide_class = ( ($refer_to == 0) && ($inner_count > 15) )? 'class="wide"': '';

				$result .= '<li '.$wide_class.'><a href="'.route('brand', $link).'">'.$items[$i]->title.'</a>';

				if($inner_count > 0){
					$result .= self::buildBrandList($items[$i]->id, $parent);
				}
				$result .= '</li>';

				if( (count($items) > 15) && (($i%15 == 14) || ($i == $n-1)) )
					$result .= '</ul>';
			}
			$result .= ($n > 15)? '</div>': '</ul>';
		}
		return $result;
	}

	public function changePerPage(Request $request){
		$data = $request->all();
		if(isset($data['per_page'])){
			$data['per_page'] = intval($data['per_page']);
			setcookie('per_page',$data['per_page'], time()+36000, '/');
			return 'success';
		}
	}
}