<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	public array $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
		'invalidchars' => \CodeIgniter\Filters\InvalidChars::class,
		'secureheaders' => \CodeIgniter\Filters\SecureHeaders::class,
		'admin_auth' => \App\Filters\AdminAuthFilter::class,
	];

	public array $globals = [
		'before' => [
			// 'csrf',
		],
		'after' => [
			'toolbar',
		],
	];

	public array $methods = [];

	public array $filters = [];
}
