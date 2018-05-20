<?php

return
	[
		'path'		=> '/shop',
		'child'		=> [
			[
				'path'       => '/',
				'obj'        => 'ShopController@index',
				'method'	 => 'get',
				'filter'     => 'IndexFilter',
				'component'  => 'shop',
				'desc'		 => 'Get all shops',
				'version'    => 1.0,
			],
			[
				'path'       => '/',
				'obj'        => 'ShopController@update',
				'method'	 => 'put',
				'filter'     => 'UpdateFilter',
				'component'  => 'shop',
				'desc'		 => 'Update shop',
				'version'    => 1.0,
			],
		],
	
	];