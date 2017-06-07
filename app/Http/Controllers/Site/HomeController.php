<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Supply\Helpers;

use Illuminate\Routing\Controller as BaseController;
use Auth;
use Crypt;
use Validator;

class HomeController extends BaseController{

	public function index(){
		$defaults = Helpers::getDefaults();
		return view('home', [
			'defaults' => $defaults
		]);
	}

	public function aboutUs(){
		$defaults = Helpers::getDefaults();
		return view('about_us', [
			'defaults' => $defaults,
			'allow_map'		=>true
		]);
	}

	public function contacts(){
		$defaults = Helpers::getDefaults();
		return view('contacts', [
			'defaults' => $defaults,
			'allow_map'		=>true
		]);
	}

	public function brand(){
		$defaults = Helpers::getDefaults();
		return view('brand', [
			'defaults' => $defaults,
		]);
	}

	public function catalog(){
		$defaults = Helpers::getDefaults();
		return view('catalog', [
			'defaults' => $defaults,
		]);
	}

	public function equipment(){
		$defaults = Helpers::getDefaults();
		return view('equipment', [
			'defaults' => $defaults,
		]);
	}

	public function request(){
		$defaults = Helpers::getDefaults();
		return view('request', [
			'defaults' => $defaults,
		]);
	}

	public function services(){
		$defaults = Helpers::getDefaults();
		return view('services', [
			'defaults' => $defaults,
		]);
	}

	public function thanks(){
		$defaults = Helpers::getDefaults();
		return view('thanks', [
			'defaults' => $defaults,
		]);
	}
}