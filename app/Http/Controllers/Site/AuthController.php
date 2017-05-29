<?php
namespace App\Http\Controllers\Site;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class AuthController extends BaseController{

	public function loginPage(){
		return view('login');
	}

	public function registrationPage(){
		return view('registration');
	}

	public function emailChange(Request $request){
		$data = $request->all();
		$data['email'] = trim($data['email']);
		$data['pass'] = trim($data['pass']);

		$user_data = Auth::user();
		$password = md5($user_data['email'].$data['pass']);
		$user = User::select('id','activated')->where('email','=',$user_data['email'])->where('password','=',$password)->first();

		//If user is not isset
		if(empty($user)){
			return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Такой пользователь не существует.']));
		}

		//If registration is not activated
		if($user->activated == 0){
			return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Пользователь не активирован.']));
		}
		var_dump($user['activation_code']);
		$activation_code = Crypt::encrypt(json_encode([strtotime(date('Y-m-d')),$data['email'],$user_data['email']]));
		var_dump($activation_code);
		User::where('id','=',$user_data['id'])->update(['activation_code'=>$activation_code]);

		$headers  = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= 'From: <hello@gmail.com>'."\r\n";
		$message = '<html>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<head><title>Смена почты на Cron System</title></head>
			<body>
				<p>Внимание! Не периходите по ссылке ниже, если вы не производили никаких действий по смене почты.</p>
				<br/>
				<p>Для подтверждения смены почты, пройдите по данной ссылке&nbsp;
					<a href="'.base_path().'/'.route('email-change-request',$activation_code).'">'.base_path().'/'.route('email-change-request',$activation_code).'</a>
				</p>
				<br/>
				<br/>
				<p>Ссылка действительна на протяжении 10 дней.</p>
			</body>
		</html>';

		mail($user_data['email'], 'Смена почты на Cron System', $message, $headers);

		return redirect(route('user-panel'))->withErrors(json_encode([
			'message'=>'На Ваш электронный адрес отправлен код подтверждения смены почты. Перейдите по указанной в письме ссылке.'
		]));
	}

	public function emailChangeRequest($code){
		$code = json_decode(Crypt::decrypt($code));
		$date = $code[0] + 864000;

		if($date <= time()){
			//drop this user
			return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Срок действия ссылки истек']));
		}else{
			$user = User::select('id')->where('email','=',$code[2])->first();
			$result = User::where('email','=',$code[1])->count();
			if($result > 0){
				return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Такой пользователь уже существует.']));
			}
			$result = User::where('id','=',$user->id)->update(['email'=>$code[1]]);
			if($result != false){
				return redirect(route('user-panel'));
			}
		}
	}

	public function passwordResetPage(Request $request){
		$data = $request->all();
		dd($data);
	}

	public function addUser(Request $request){
		$data = $request->all();

		$data['email'] = trim($data['email']);
		$data['pass'] = trim($data['pass']);
		$data['confimPass'] = trim($data['confimPass']);

		//User already isset
		$user_isset = User::select('email')->where('email','=',$data['email'])->count();
		//Send error
		if($user_isset > 0){
			return redirect(route('registration-page'))->withErrors(json_encode(['user_isset'=>'']));
		}

		//Validate registration data
		$fail = Validator::make($data, [
			'email'		=> 'required|min:5|max:255|email',
			'pass'		=> 'required|min:6',
			'confimPass'=> 'required|same:pass'
		]);
		//Send Validation errors
		if($fail->fails()){
			return redirect(route('registration-page'))->withErrors(json_encode($fail->errors()));
		}

		//If allright
		$password = md5($data['email'].$data['pass']);
		$activation_code = Crypt::encrypt(serialize([strtotime(date('Y-m-d')),base64_encode($data['email'])]));
		//Create user
		User::create([
			'email' => $data['email'],
			'password' => $password,
			'role' => '',
			'activated' => 0,
			'activation_code' => $activation_code
		]);

		//Send Letter to user with registration activation code
		$headers  = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= 'From: <hello@gmail.com>'."\r\n";
		$message = '<html>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<head><title>Регистрация на Cron System</title></head>
			<body>
				<p>Вы зарегистрированы!</p>
				<br/>
				<p>Осталось только подтвердить регистрацию и пререйти по ссылке&nbsp;
					<a href="'.base_path().'/'.route('registration-confirm',$activation_code).'">'.base_path().'/'.route('registration-confirm',$activation_code).'</a>
				</p>
				<br/>
				<br/>
				<p>Ссылка действительна на протяжении 10 дней.</p>
			</body>
		</html>';

		mail($data['email'], 'Регистрация на Cron System', $message, $headers);

		//if user created redirect home
		return redirect(route('home'))->withErrors(json_encode([
			'message'=>'Теперь Вы зарегистрированы. На Ваш электронный адрес отправлен код подтверждения регистрации. Перейдите по указанной в письме ссылке.'
		]));
	}

	public function registrationConfirmPage($code){
		$code = unserialize(Crypt::decrypt($code));
		$date = $code[0] + 864000;
		$email = base64_decode($code[1]);
		//if expire date is failed
		if($date <= time()){
			//drop this user
			User::where('email','=',$email)->delete();
			return view('registration_failed');
		}else{
			$user = User::select('id')->where('email','=',$email)->first();
			$auth = Auth::loginUsingId($user->id);
			if(!$auth){
				User::where('email','=',$email)->delete();
				return view('registration_failed');
			}else{
				User::where('id','=',$user->id)->update(['activated'=>1]);
				return redirect(route('home'));
			}
		}
	}

	public function login(Request $request){
		$data = $request->all();

		$data['email'] = trim($data['email']);
		$data['pass'] = trim($data['pass']);

		//Validate login data
		$fail = Validator::make($data, [
			'email'		=> 'required|min:5|max:255|email',
			'pass'		=> 'required|min:6',
		]);

		//If validation failed redirect with errors
		if($fail->fails()){
			return redirect(route('login-page'))->withErrors(json_encode($fail->errors()));
		}

		$password = md5($data['email'].$data['pass']);
		$user = User::select('id','activated')->where('email','=',$data['email'])->where('password','=',$password)->first();

		//If user is not isset
		if(empty($user)){
			return redirect(route('login-page'))->withErrors(json_encode(['message'=>'Такой пользователь не существует.']));
		}

		//If registration is not activated
		if($user->activated == 0){
			return redirect(route('login-page'))->withErrors(json_encode(['message'=>'Пользователь не активирован.']));
		}

		$auth = Auth::loginUsingId($user->id);
		//If authentication is failed
		if(!$auth){
			return redirect(route('login-page'))->withErrors(json_encode(['message'=>'Сбой аутентификации. Обратитесь к администратору сайта.']));
		}
		return redirect(route('home'));
	}

	public function logout(){
		Auth::logout();
		return redirect(route('home'));
	}
}