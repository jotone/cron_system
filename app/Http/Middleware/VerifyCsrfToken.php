<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [
		'/add_to_card',
		'/change_filter',
		'/change_per_page',
		'/drop_from_cart',
		'/thanks',
		'/update_cart',
		'/ask_question',
		'/order_phone_call',
		'/specify_price',
	];
}
