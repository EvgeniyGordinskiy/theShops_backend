<?php

return
[
	// ===============================    PATHS   ===============================
	'log' => [
		'path'  => SITE_ROOT.DIRECTORY_SEPARATOR.'storage/log',
		'byDay' => true
	],
	'app_routes'           => SITE_ROOT.'/App/routes.php',
	'controller_path'      => SITE_ROOT."/App/versions/v",
	'migrations_path'      => SITE_ROOT.'/database/migrations',
	'seeds_path'     	   => SITE_ROOT.'/database/seeds',
	'jwt_private_key_file' => SITE_ROOT.'/config/private.key',
	'jwt_public_key_file'  => SITE_ROOT.'/config/public.pem',

	// ===============================   VARIABLES  ===============================
	'routes_rows'     => [
							'obj',
							'filter',
							'version',
							'beforeRoute',
							'afterRoute',
	],
	'session' => 'memchached',

	'days_of_week' => [
		'sunday',
		'monday',
		'tuesday',
		'wednesday',
		'thursday',
		'friday',
		'saturday',
	]
];