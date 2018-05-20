<?php
use \App\Services\Route\Route;
use \App\Services\Http\Request\Request;

$request = new Request();
$method = $request->server->getMethod();
$url = $request->server->getUri()->getPath();
$router = Route::create();

if ( !$router->parseRoute($url, strtolower($method)) ) {
	throw new \App\Services\Exceptions\RouteException('Route not found', 404);
}
$router::handle(Request::getValues());
