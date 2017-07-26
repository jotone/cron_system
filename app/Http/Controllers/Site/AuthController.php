<?php
namespace App\Http\Controllers\Site;

use App\EmailResets;
use App\PasswordResets;
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
		if(isset($_COOKIE['shopping_cart'])){
			unset($_COOKIE['shopping_cart']);
			setcookie('shopping_cart', null, -3600);
		}
		return redirect(route('home'));
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
		$result = User::create([
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

	public function emailChange(Request $request){
		$data = $request->all();
		$data['email'] = trim($data['email']);
		$data['password'] = trim($data['password']);
		$user_data = Auth::user();
		$password = md5($user_data['email'].$data['password']);
		$user = User::select('id','activated')->where('email','=',$user_data['email'])->where('password','=',$password)->first();

		//If user is not isset
		if(empty($user)){
			return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Такой пользователь не существует.']));
		}

		//If registration is not activated
		if($user->activated == 0){
			return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Пользователь не активирован.']));
		}

		$email_reset = EmailResets::create([
			'old_email'	=> $user_data['email'],
			'new_email'	=> $data['email'],
			'password'	=> $data['password'],
			'user_id'	=> $user['id']
		]);
		$activation_code = Crypt::encrypt(json_encode($email_reset->id));
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
		$email_reset = EmailResets::find($code);
		if(!$email_reset){
			return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Срок действия ссылки истек']));
		}

		$date = strtotime($email_reset->created_at) + 864000;
		if($date <= time()){
			return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Срок действия ссылки истек']));
		}else{
			$password = md5($email_reset->old_email.$email_reset->password);
			$user = User::select('id')->where('email','=',$email_reset->old_email)->where('password','=',$password)->first();
			if(empty($user)){
				return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Такого пользователя не существует.']));
			}

			$result = User::where('email','=',$email_reset->new_email)->count();
			if($result > 0){
				return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Такой пользователь уже существует.']));
			}

			$password = md5($email_reset->new_email.$email_reset->password);
			$result = User::where('id','=',$user->id)->update(['email'=>$email_reset->new_email, 'password'=>$password]);
			EmailResets::where('id','=',$email_reset->id)->delete();
			EmailResets::where('user_id','=',$email_reset->user_id)->delete();
			if($result != false){
				return redirect(route('user-panel'));
			}
		}
	}

	public function passwordChange(Request $request){
		$data = $request->all();
		$data['old_password'] = trim($data['old_password']);
		$data['new_password'] = trim($data['new_password']);
		$data['conf_new_password'] = trim($data['conf_new_password']);
		$user = Auth::user();
		$password = md5($user['email'].$data['old_password']);
		$user = User::select('id','activated')->where('email','=',$user['email'])->where('password','=',$password)->first();
		//If user is not isset
		if(empty($user)){
			return json_encode(['error'=>'Пароль не верен.','type'=>'old_password']);
		}

		//If registration is not activated
		if($user->activated == 0){
			return json_encode(['error'=>'Пользователь не активирован.','type'=>'not_activated']);
		}

		if(strlen($data['new_password']) < 6){
			return json_encode(['error'=>'Пароль должен быть не короче 6-ти символов.','type'=>'new_password']);
		}
		if($data['new_password'] != $data['conf_new_password']){
			return json_encode(['error'=>'Пароль подтвержден не верно.','type'=>'conf_password']);
		}

		$password_reset = PasswordResets::create([
			'user_id'	=> $user['id'],
			'token'		=> $data['new_password'],
		]);
		$activation_code = Crypt::encrypt(json_encode($password_reset->id));
		User::where('id','=',$user['id'])->update(['recovery_token'=>$activation_code]);

		$headers  = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= 'From: <hello@gmail.com>'."\r\n";
		$message = '<html>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<head><title>Смена пароля на Cron System</title></head>
			<body>
				<p>Внимание! Не периходите по ссылке ниже, если вы не производили никаких действий по смене пароля.</p>
				<br/>
				<p>Для подтверждения смены пароля, пройдите по данной ссылке&nbsp;
					<a href="'.base_path().'/'.route('email-change-request',$activation_code).'">'.base_path().'/'.route('email-change-request',$activation_code).'</a>
				</p>
				<br/>
				<br/>
				<p>Ссылка действительна на протяжении 10 дней.</p>
			</body>
		</html>';

		mail($user['email'], 'Смена пароля на Cron System', $message, $headers);

		return json_encode([
			'message'=>'success',
			'text'=>'На Ваш электронный адрес отправлен код подтверждения смены пароля. Перейдите по указанной в письме ссылке.'
		]);
	}

	public function passwordChangeRequest($code){
		$code = json_decode(Crypt::decrypt($code));
		$pass_reset = PasswordResets::find($code);
		if(!$pass_reset){
			return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Срок действия ссылки истек']));
		}

		$date = strtotime($pass_reset->created_at) + 864000;
		if($date <= time()){
			return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Срок действия ссылки истек']));
		}else{
			$user = User::find($pass_reset->user_id);

			if(empty($user)){
				return redirect(route('user-panel'))->withErrors(json_encode(['message'=>'Такого пользователя не существует.']));
			}
			$password = md5($user->email.$pass_reset->token);

			$result = User::where('id','=',$user->id)->update(['password'=>$password]);
			PasswordResets::where('id','=',$pass_reset->id)->delete();
			PasswordResets::where('user_id','=',$pass_reset->user_id)->delete();
			if($result != false){
				return redirect(route('user-panel'));
			}
		}
	}

	public function passwordResetPage(){
		return view('reset_password');
	}

	public function passwordResetRequest(Request $request){
		$data = $request->all();

		$user = User::select('id','email')->where('email','=',$data['email'])->first();
		if(empty($user)){
			return redirect(route('password-reset'))->withErrors(json_encode(['email'=>'Такой почты не существует.']));
		}

		$chars='1234567890abcdefghijklmnopqrstuvwxyz';
		$max=12;
		$size=strlen($chars)-1;
		$password='';

		while($max--) $password.=$chars[rand(0,$size)];

		$pass_mail = $password;

		$password = md5($user['email'].$password);
		User::where('id','=',$user->id)->update(['password'=>$password]);

		$headers  = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= 'From: <hello@gmail.com>'."\r\n";
		$message = '<html>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<head><title>Смена пароля на Cron System</title></head>
			<body>
				<p>Ваш пароль изменен</p>
				<br/>
				<p>Для входа используйте пароль: '.$pass_mail.'</p>
			</body>
		</html>';

		mail($user['email'], 'Смена пароля на Cron System', $message, $headers);

		return redirect(route('home'))->withErrors(json_encode(['message'=>'На Ваш электронный адрес отправлен новый пароль.']));
	}
}