<?php
namespace App\Http\Controllers\Supply;
use App\AdminMenu;
use App\UserRoles;
use Auth;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\URL;
use League\Flysystem\Exception;

class Functions extends BaseController{
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
}