<?php
namespace App\Http\Controllers\Supply;
use App\AdminMenu;
use App\Brand;
use App\News;
use App\Category;
use App\PageContent;
use App\Pages;
use App\Products;
use App\Services;
use App\UserRoles;
use App\Vacancies;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Functions extends BaseController{
	public static function getMinMaxPrice(){
		$products=Products::select('price')->where('enabled','=',1)->get();
		$res['min']=0;
		$res['max']=0;
		foreach($products as $product){
			if($res['min']>=$product->price){
				$res['min']=$product->price;
			}
			if($res['max']<=$product->price){
				$res['max']=$product->price;
			}
		}
		return $res;
	}

	public static function getMicrotime(){
		$time = microtime();
		$time = explode(' ', $time);
		return $time[1] + $time[0];
	}

	public static function checkAccessToPage($path){
		$path = (substr($path, 0,1) != '/')? '/'.$path: $path;
		$path = explode('/',$path);
		if($path[count($path)-1] == 'add'){
			unset($path[count($path)-1]);
		}
		if($path[count($path)-2] == 'edit'){
			unset($path[count($path)-1]);
			unset($path[count($path)-1]);
		}
		$path = implode('/',$path);

		$admin = Auth::user();
		$admin_roles = UserRoles::select('pseudonim','access_pages')->where('pseudonim','=',$admin['role'])->first();
		if($admin_roles->access_pages == 'allow_all'){
			return true;
		}
		$allowed_pages = json_decode($admin_roles->access_pages);

		$current_page = AdminMenu::select('id','slug')->where('slug','=',$path)->first();
		return (!in_array($current_page->id, $allowed_pages));
	}

	public static function strip_data($text){
		$quotes = array("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!" );
		$goodquotes = array("-", "+", "#" );
		$repquotes = array("\-", "\+", "\#" );
		$text = trim(strip_tags($text));
		$text = str_replace($quotes,'',$text);
		$text = str_replace($goodquotes,$repquotes,$text);
		$text = str_replace(" +"," ",$text);
		return $text;
	}

	public static function rgb2hex($rgb) {
		if(!is_array($rgb)){
			$rgb = substr($rgb,4,-1);
			$rgb = explode(', ',$rgb);
		}
		$hex = "#";
		$hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
		return $hex;
	}
	public static function rus2translit($string) {
		//Массив трансформации букв
		$converter = [
			'а'=>'a',	'б'=>'b',	'в'=>'v',	'г'=>'g',	'д'=>'d',	'е'=>'e',
			'ё'=>'e',	'ж'=>'zh',	'з'=>'z',	'и'=>'i',	'й'=>'j',	'к'=>'k',
			'л'=>'l',	'м'=>'m',	'н'=>'n',	'о'=>'o',	'п'=>'p',	'р'=>'r',
			'с'=>'s',	'т'=>'t',	'у'=>'u',	'ф'=>'f',	'х'=>'h',	'ц'=>'ts',
			'ч'=>'ch',	'ш'=>'sh',	'щ'=>'shch','ь'=>'',	'ы'=>'y',	'ъ'=>'',
			'э'=>'e',	'ю'=>'yu',	'я'=>'ya',	'і'=>'i',	'ї'=>'i',	'є'=>'ie',
			'А'=>'A',	'Б'=>'B',	'В'=>'V',	'Г'=>'G',	'Д'=>'D',	'Е'=>'E',
			'Ё'=>'E',	'Ж'=>'Zh',	'З'=>'Z',	'И'=>'I',	'Й'=>'J',	'К'=>'K',
			'Л'=>'L',	'М'=>'M',	'Н'=>'N',	'О'=>'O',	'П'=>'P',	'Р'=>'R',
			'С'=>'S',	'Т'=>'T',	'У'=>'U',	'Ф'=>'F',	'Х'=>'H',	'Ц'=>'Ts',
			'Ч'=>'Ch',	'Ш'=>'Sh',	'Щ'=>'Shch','Ь'=>'',	'Ы'=>'Y',	'Ъ'=>'',
			'Э'=>'E',	'Ю'=>'Yu',	'Я'=>'Ya',	'І'=>'I',	'Ї'=>'I',	'Є'=>'Ie'
		];
		//замена кирилицы входящей строки на латынь
		return strtr($string, $converter);
	}
	public static function str2url($str){
		$str = self::rus2translit($str);
		$str = strtolower($str);
		$str = preg_replace('~[^-a-z0-9_\.\#\/]+~u', '_', $str);
		$str = trim($str, "_");
		return $str;
	}
	public static function is_serialized($value, &$result = null){
		if (!is_string($value)){return false;}
		if ($value === 'b:0;'){
			$result = false;
			return true;
		}
		$length	= strlen($value);
		$end	= '';
		if(empty($value)) return false;
		switch ($value[0]){
			case 's': if ($value[$length - 2] !== '"'){return false;}
			case 'b':
			case 'i':
			case 'd': $end .= ';';
			case 'a':
			case 'O':
				$end .= '}';
				if($value[1] !== ':'){return false;}
				switch ($value[2]) {
					case 0:
					case 1:
					case 2:
					case 3:
					case 4:
					case 5:
					case 6:
					case 7:
					case 8:
					case 9: break;
					default: return false;
				}
			case 'N':
				$end .= ';';
				if($value[$length - 1] !== $end[0]){return false;}
				break;
			default: return false;
		}
		if (($result = @unserialize($value)) === false){
			$result = null;
			return false;
		}
		return true;
	}

	public static function buildMenuList($path, $refer_to = 0){
		$path = (substr($path, 0,1) != '/')? '/'.$path: $path;

		$menu = AdminMenu::select('id','title','slug','position','refer_to')
			->where('refer_to','=',$refer_to)
			->orderBy('position','asc')
			->get();

		$result= '';
		if(isset($menu[0])){
			$result .= '<ul>';
			foreach($menu as $item){
				$count = AdminMenu::select('refer_to')
					->where('refer_to','=',$item->id)
					->count();
				$cross = ($count > 0)? 'has_child': '';

				$item_slug = (0 != $item->module_id)? '/admin/'.$item->slug: $item->slug;

				$active = ($path == $item_slug)? ' active': '';
				$result.= '<li data-id="'.$item->id.'"><a href="'.$item_slug.'" class="'.$cross.$active.'">'.$item->title.'</a>';
				if($count > 0){
					$result.= self::buildMenuList($path, $item->id);
				}
				$result.= '</li>';
			}
			$result .= '</ul>';
		}

		return $result;
	}

	public static function convertDate($date){
		if(!empty($date)){
			$year = substr($date,0,4);
			$month = substr($date,5,2);
			switch($month){
				case '1': $month_name = 'Янв'; break;
				case '2': $month_name = 'Фев'; break;
				case '3': $month_name = 'Мар'; break;
				case '4': $month_name = 'Апр'; break;
				case '5': $month_name = 'Май'; break;
				case '6': $month_name = 'Июн'; break;
				case '7': $month_name = 'Июл'; break;
				case '8': $month_name = 'Авг'; break;
				case '9': $month_name = 'Сен'; break;
				case '10':$month_name = 'Окт'; break;
				case '11':$month_name = 'Ноя'; break;
				case '12':$month_name = 'Дек'; break;
			}
			$day = substr($date,8,2);
			$time = substr($date,11,5);
			return $day.'/'.$month_name.'/'.$year.' '.$time;
		}else{
			return 'Не известно';
		}
	}

	public static function createImg($img_url, $use_img_check = true){
		if( ('undefined' != $img_url) && (!empty($img_url)) ){
			$destinationPath = base_path().'/public/img/';//Указываем папку хранения картинок
			$img_file = pathinfo(self::str2url($img_url->getClientOriginalName()));//Узнаем реальное имя файла
			$img_file['extension'] = strtolower($img_file['extension']);
			if($use_img_check){
				if(
					($img_file['extension'] != 'png') &&
					($img_file['extension'] != 'jpg') &&
					($img_file['extension'] != 'jpeg') &&
					($img_file['extension'] != 'gif') &&
					($img_file['extension'] != 'svg') &&
					($img_file['extension'] != 'bmp')
				){
					return '';
				}
			}
			$img_file = $img_file['filename'].'_'.substr(uniqid(),6).'.'.$img_file['extension'];
			$img_url -> move($destinationPath, $img_file);
			$img_file = '/img/'.$img_file;
		}else{
			$img_file = '';
		}
		return $img_file;
	}

	public static function buildVerticalOptionList($table, $id='', $current_id = 0, $refer_to = 0, $parent = '', $result = ''){
		$items = \DB::table($table)->select('id','title')->where('refer_to','=',$refer_to)->orderBy('title','asc')->get();
		if(!empty($items)){
			foreach($items as $item){
				if($item->id != $current_id){
					$parent_title = (!empty($parent))? $parent.' &rarr; ': '';
					$selected = ($item->id == $id)? 'selected="selected"': '';

					$result .= '<option value="'.$item->id.'" '.$selected.'>'.$parent_title.$item->title.'</option>';

					$inner_isset = \DB::table($table)->where('refer_to','=', $item->id)->count();
					if($inner_isset > 0){
						$result .= self::buildVerticalOptionList($table, $id, $current_id, $item->id, $parent_title.$item->title);
					}
				}
			}
		}
		return $result;
	}

	public static function buildCategoriesView($table, $refer_to = 0, $result = ''){
		$items = \DB::table($table)->where('refer_to','=',$refer_to)
			->orderBy('position','asc')
			->get();
		if(!empty($items)){
			$result .= '<ul data-refer="'.$refer_to.'">';
			foreach($items as $item){
				$class = ($item->enabled == 1)? ['trigger_on','on']: ['trigger_off','off'];
				switch($table){
					case 'brands': $link = 'admin-brands-edit'; break;
					case 'categories': $link = 'admin-categories-edit'; break;
				}
				$result .= '
				<li data-id="'.$item->id.'">
					<div class="category-wrap">
						<div class="category-title">
							<div class="sort-controls">
								<p data-direction="up">▲</p>
								<p data-direction="down">▼</p></div>
							<div>'.$item->title.'</div>
						</div>
						<div class="category-slug">'.$item->slug.'</div>
						<div class="timestamps">
							<p>Создан: '.self::convertDate($item->created_at).'</p>
							<p>Изменен: '.self::convertDate($item->updated_at).'</p>
						</div>
						<div class="category-controls">
						<a class="button '.$class[0].'" href="#" title="Вкл/Выкл">'.$class[1].'</a>
							<a class="button edit" href="'.route($link, $item->id).'" title="Редактировать">
								<img src="'.\URL::asset('images/edit.png').'" alt="Редактировать">
							</a>
							<a class="button drop" href="#" title="Удалить" data-title="'.$item->title.'">
								<img src="'.\URL::asset('images/drop.png').'" alt="Удалить">
							</a>
						</div>
					</div>';
				$inner_count = \DB::table($table)->where('refer_to','=',$item->id)->count();
				if($inner_count > 0){
					$result .= self::buildCategoriesView($table, $refer_to = $item->id);
				}
				$result .='
					<ul class="empty" data-refer="'.$item->id.'"></ul>
				</li>';
			}
			$result .= '</ul>';
		}
		return $result;
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
			$temp = explode('/',$image);
			$temp = $temp[count($temp) -1];

			$images = News::select('title')
				->where('img_url','LIKE','%'.$temp.'%')
				->orWhere('text','LIKE','%'.$temp.'%')
				->get();
			foreach($images as $item) $used_in['news'][] = $item->title;

			$images = Products::select('title')
				->where('img_url','LIKE','%'.$temp.'%')
				->orWhere('text','LIKE','%'.$temp.'%')
				->get();
			foreach($images as $item) $used_in['products'][] = $item->title;

			$images = Vacancies::select('title')
				->where('img_url','LIKE','%'.$temp.'%')
				->orWhere('text','LIKE','%'.$temp.'%')
				->get();
			foreach($images as $item) $used_in['vacancies'][] = $item->title;

			$images = PageContent::select('id')
				->where('meta_value','LIKE','%'.$temp.'%')
				->get();
			foreach($images as $item){
				$pages = Pages::select('title')
					->where('content','LIKE','%'.$item->id.'%')
					->get();
				foreach($pages as $page){
					$used_in['pages'][] = $page->title;
				}
			}

			$images = Services::select('title')
				->where('img_url','LIKE','%'.$temp.'%')
				->orWhere('text','LIKE','%'.$temp.'%')
				->get();
			foreach($images as $item) $used_in['services'][] = $item->title;

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

	public static function getParentBrand($id){
		$brand = Brand::select('title','slug','refer_to')->find($id);
		if($brand->refer_to == 0){
			return [
				'title'=> $brand->title,
				'slug' => $brand->slug
			];
		}else{
			return self::getParentBrand($brand->refer_to);
		}
	}

	public static function getChildBrandIDArray($array){
		$res_arr=[];
		foreach($array as $element){
			$brands = Brand::select('id','refer_to','is_last')->where('refer_to','=',$element)->get();
			foreach($brands as $brand){
				if($brand->is_last == 1){
		$res_arr=array_merge($res_arr,[$brand->id]);
				}else{
					$res_arr=array_merge($res_arr,self::getChildBrandIDArray([$brand->id]));
				}
			}
		}
		return $res_arr;
	}


	//Получение списка дочерних брендов
	public static  function getChildBrands($id){
		$brands=[];
		if($id==-1){
			$brands=Brand::all();
		}else{
			$brands = Brand::where('refer_to',$id)->get();
		}
		return $brands;
	}

	// Добавление бренда по его тайтлу
	private static function addBrandItem($title,$refer_to,$is_last){
		$last_pos = Brand::select('position')
			->where('refer_to','=',$refer_to)
			->orderBy('position','desc')
			->first();
		$position = (!empty($last_pos))? $last_pos->position +1: 0;
		$result = Brand::create([
			'title'		=> trim($title),
			'slug'		=> trim(self::str2url($title)),
			'refer_to'	=> $refer_to,
			'position'	=> $position,
			'need_seo'	=> 0,
			'seo_title'	=> $title,
			'seo_text'	=> $title,
			'is_last'	=> $is_last,
			'enabled'	=> 1
		]);
		return $result->id;
	}

	//Создание связного списка категорий
	private static function  setBrandList($array,$id){
		$i=0;
		foreach ($array as $el){
			$is_last=0;
			if($i==count($array)-1) $is_last=1;
			$id=self::addBrandItem($el,$id,$is_last);
			$i++;
		}
		return 1;
	}

	// поиск последнего вхождения в существующий список категорий
	private static function searchLastChildImportBrand($array,$index,$id){
		$brands=self::getChildBrands($id);
		foreach ($brands as $brand){
			if($brand->title==$array[$index] && count($array)>$index){
				return self::searchLastChildImportBrand($array,$index+1,$brand->id);
			}
		}
		if($id==-1)$id=0;
		return ['id'=>$id,'index'=>$index,'array'=>array_slice($array,$index)];
	}

	//Импортирование списка брендов
	public static function addBrandList($array){
		$res_search= self::searchLastChildImportBrand($array,0,-1);
		$res=self::setBrandList($res_search['array'],$res_search['id']);
		return print_r($res_search,true);
	}


	private static function makeDataProductArr($array){
		$data=array();
		$data['image_type']='file';
		$data['image']=$array[6];
		$data['image_alt']=$array[6];
		if(intval($array[0])!=0){
			$product = Products::select('id')
				->where('import_id','=',intval($array[0]))
				->first();
			$data['id']=(!empty($product))?$product->id:Null;
		}
		$data['import_id']=$array[0];
		$data['title']=$array[2];
		$data['slug']=trim(self::str2url($array[2]));
		$data['text']=$array[3];
		$data['old_price']=$array[5];
		$data['price']=$array[4];
		//
		$category = Category::select('id')
			->where('title','LIKE',$array[9])
			->first();
		$data['category']=(!empty($category))?$category->id:0;

		$brand = Brand::select('id')
			->where('title','LIKE',$array[1])
			->first();
		$data['brand']=(!empty($brand))?$brand->id:0;
		//
		$data['rating']=$array[8];
		$data['is_hot']=$array[7];
		$data['show_on_main']=0;
		$data['enabled']=1;
		return $data;
	}

		//Import products
	public static function addProductList($array){
		$data=self::makeDataProductArr($array);
		if($data['image_type'] == 'file'){
			$img_url = json_encode([
				'img'=>$data['image'],
				'alt'=>$data['image_alt']
			]);
		}else{
			$image = Functions::createImg($data['image'], true);
			$img_url = json_encode([
				'img'=>$image,
				'alt'=>$data['image_alt']
			]);
		}

		$create_array=[
			'title'				=> trim($data['title']),
			'slug'				=> trim($data['slug']),
			'text'				=> $data['text'],
			'img_url'			=> $img_url,
			'old_price'			=> str_replace(',','.',$data['old_price']),
			'price'				=> str_replace(',','.',$data['price']),
			'refer_to_category'	=> $data['category'],
			'refer_to_brand'	=> $data['brand'],
			'rating'			=> ( ($data['rating'] == 'undefined') || ($data['rating'] == '') )? 0: $data['rating'],
			'is_hot'			=> $data['is_hot'],
			'show_on_main'		=> $data['show_on_main'],
			'views'				=> 0,
			'enabled'			=> $data['enabled'],
			'published_at'		=> date('Y-m-d H:i:s'),
			'import_id'			=> $data['import_id']
		];
		if( (isset($data['id'])) && (!empty($data['id'])) ){
			$result = Products::find($data['id']);
			$result->title				= trim($data['title']);
			$result->slug				= trim($data['slug']);
			$result->text				= $data['text'];
			$result->img_url			= $img_url;
			$result->old_price			= str_replace(',','.',$data['old_price']);
			$result->price				= str_replace(',','.',$data['price']);
			$result->refer_to_category	= $data['category'];
			$result->refer_to_brand		= $data['brand'];
			$result->rating				= ( ($data['rating'] == 'undefined') || ($data['rating'] == '') )? 0: $data['rating'];
			$result->is_hot				= $data['is_hot'];
			$result->show_on_main		= $data['show_on_main'];
			$result->enabled			= $data['enabled'];
			if($result->enabled > 0){
				$result->published_at = date('Y-m-d H:i:s');
			}
			$result->save();
		}else{
			$result = Products::create([
				'title'				=> trim($data['title']),
				'slug'				=> trim($data['slug']),
				'text'				=> $data['text'],
				'img_url'			=> $img_url,
				'old_price'			=> str_replace(',','.',$data['old_price']),
				'price'				=> str_replace(',','.',$data['price']),
				'refer_to_category'	=> $data['category'],
				'refer_to_brand'	=> $data['brand'],
				'rating'			=> ( ($data['rating'] == 'undefined') || ($data['rating'] == '') )? 0: $data['rating'],
				'is_hot'			=> $data['is_hot'],
				'show_on_main'		=> $data['show_on_main'],
				'views'				=> 0,
				'enabled'			=> $data['enabled'],
				'published_at'		=> date('Y-m-d H:i:s'),
								'import_id'			=> $data['import_id']
			]);
		}
		return $create_array;
		if($result != false){
			return 1;
		}else{
			return 0;
		}
	}
}