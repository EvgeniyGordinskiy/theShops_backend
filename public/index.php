<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use App\Services\Log\Log;

set_error_handler(function( $num, $str, $file, $line, $context ) {

	// Catch notices and warnings
	if ($num === 8 || $num === 2) {
		new Log(false, $str, $file, $line);
	}

	(new \App\Services\Http\Response\Response())->setStatusCode(500);
	return false;
});

require  "../init.php";






