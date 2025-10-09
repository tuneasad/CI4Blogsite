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
		'session'  => \CodeIgniter\Shield\Filters\SessionAuth::class,
		'token'    => \CodeIgniter\Shield\Filters\TokenAuth::class,
		'chain'    => \CodeIgniter\Shield\Filters\ChainAuth::class,
		'auth-rates' => \CodeIgniter\Shield\Filters\AuthRates::class,
		'group'    => \CodeIgniter\Shield\Filters\GroupFilter::class,
		'permission' => \CodeIgniter\Shield\Filters\PermissionFilter::class,
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
