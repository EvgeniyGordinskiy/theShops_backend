<?php

define('SITE_ROOT', __DIR__);

require_once __DIR__.'/utils.php';

$loader   = require_once __DIR__.'/vendor/autoload.php';

if ( php_sapi_name() !== 'cli') {
    $bootstrap = require_once __DIR__.'/bootstrap/app.php';
}



