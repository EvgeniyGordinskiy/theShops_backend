<?php

namespace App\Services\Hypermedia\Hal;

use App\Services\Hypermedia\Hypermedia;
use App\Services\Route\Route;
use App\Services\Route\Routes_filter\Filter;

class Hal implements Hypermedia
{
    public $links = [];
    public function create($class)
    {
        $routes = Route::$all_routes;
        if ( is_array($routes) ) {
            foreach ($routes as $route) {
                if (strstr($route['obj'], '@', true) === $class) {
                    $this->links[$route['desc']] = $route['api_path'];
                }
            }
            return $this->links;
        }
    }

}