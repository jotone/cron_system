<?php
namespace App\Http\Controllers\Admin;

use App\AdminMenu;
use App\EtcData;

use App\Http\Controllers\Supply\Functions;
use App\SocialMenu;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class ContactsController extends BaseController{

	public function index(Request $request){
		$allow_access = Functions::checkAccessToPage($request->path());
		if($allow_access){
			$start = Functions::getMicrotime();
			$page_caption = AdminMenu::select('title','slug')->where('slug','LIKE','%'.$request->path().'%')->first();
			$menu = Functions::buildMenuList($request->path());

			$content = EtcData::where('label','=','info')->get();

			$social = SocialMenu::orderBy('position','asc')->get();
			$list = ['social'=>[
				'title'	=> 'Социальные Сети',
				'val'	=> $social
			]];
			foreach($content as $item){
				switch($item->key){
					case 'marker_coordinates': $value = json_decode($item->value); break;
					default: $value = $item->value;
				}
				$list[$item->key] = [
					'title'	=> $item->title,
					'val'	=> $value
				];
			}
			return view('admin.info', [
				'start'		=> $start,
				'menu'		=> $menu,
				'page_title'=> $page_caption->title,
				'content'	=> $list
			]);
		}
	}

	public function save(Request $request){
		$data = $request->all();
		if($data['image_type'] == 'file'){
			$img_url = $data['image'];
		}else{
			$img_url = Functions::createImg($data['image'], true);
		}

		SocialMenu::truncate();
		$socials = json_decode($data['social']);
		foreach($socials as $social){
			switch($social->type){
				case 'facebook':	$title = 'FaceBook'; break;
				case 'google_plus':	$title = 'Google+'; break;
				case 'instagram':	$title = 'Instagram'; break;
				case 'linkedin':	$title = 'LinkedIn'; break;
				case 'livejournal':	$title = 'LiveJournal'; break;
				case 'mailru':		$title = 'MailRu'; break;
				case 'pinterest':	$title = 'Pinterest'; break;
				case 'twitter':		$title = 'Twitter'; break;
				case 'viber':		$title = 'Viber'; break;
				case 'whatsapp':	$title = 'WhatsApp'; break;
				case 'vkontakte':	$title = 'Вконтакте'; break;
				case 'odnoklassniki':$title= 'Одноклассники'; break;
				default: $title = '';
			}
			SocialMenu::create([
				'title' => $title,
				'slug'  => $social->type,
				'link'  => $social->val,
				'position'=>$social->pos
			]);
		}

		foreach($data as $key => $value){
			switch($key){
				case 'address':
				case 'marker_coordinates':
				case 'email':
				case 'phone':
				case 'work_time':
					$result = EtcData::where('label','=','info')
						->where('key','=',$key)
						->update(['value'=>$value]);
				break;
				case 'image':
					$result = EtcData::where('label','=','info')
						->where('key','=','map_marker')
						->update(['value'=>$img_url]);
				break;
			}
		}

		return json_encode(['message'=>'success']);
	}
}