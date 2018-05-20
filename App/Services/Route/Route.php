<?php
namespace App\Services\Route;
use App\Services\Exceptions\BaseException;
use App\Services\Exceptions\FilterException;
use App\Services\Exceptions\RouteException;
use App\Services\Filter\IFilter;
use App\Services\Http\Request\Request;
use App\Services\Http\Response\Response;
use App\Services\Permissions\Permission;
use App\Services\Route\Routes_filter\Filter;

class Route
{

	public $routes;
	private $filter;
	private $parentRoute;
	private $parentChild;
	private static $_state;
	public static $currentRoute;
	public static $all_routes;


    private function __construct()
    {
		$routes = require_once config('app', 'app_routes');
		$this->filter = new Filter();


		foreach ($routes as $route) {
			$this->parentRoute = '';
			$this->merge_routes($route, true);
		}

		self::$all_routes = $this->routes;
    }

	public static function create()
    {
		return self::getState();
    }

	/**
	 * If !self::$_state,
	 * creating new instance of the connect current Data Base and create new self.
	 */
	private static function getState()
	{
		if (!self::$_state) {
			self::$_state =	new self();
		}
		return self::$_state;
	}

	/**
	 *  Create array of all routes
	 * @param $route
	 * @param array $parent
	 */
    private function merge_routes($route, $parent = [])
    {
		$this->filter->transform($route);
        $this->parentRoute .= $route['path'];

        if ( $this->parentRoute && $route['obj'] ) {
            $route['path'] = $this->parentRoute;
            $this->addRoute($route);
        }

		if ( key_exists('child', $route) ) {
			if ( isset($url) ) {
				unset($this->routes[$url]['child']);
			}

			foreach ($route['child'] as $key => $child) {
				$this->merge_routes($child);
			}
		}
    }

    public function parseRoute($route, $method)
    {
	    $route = preg_replace('/[^a-zA-Z0-9\/_-]+/', '', $route);
		$key = $route.'_'.$method;
        if ( array_key_exists($key, $this->routes) ) {
		    self::$currentRoute = $this->routes[$key];
		    return $this->routes[$key];
		} 

		return false;
    }

    public static function handle ($values = [])
    {
        $file = strstr(self::$currentRoute['obj'], '@', true);
        $method = substr(strstr(self::$currentRoute['obj'], '@'), 1);
        try {
            $newClass = 'App\\versions\\v' . self::$currentRoute['version'] ."\\". self::$currentRoute['component'] . '\\' . $file;
            $object = new $newClass();

            if ( self::$currentRoute['filter'] && $values) {
                if ($cleanValues = Filter::filterInputValues(self::$currentRoute, $values)) {
                    $values = $cleanValues;
                }
            }
            call_user_func_array([$object, $method], $values);
            }catch (\Exception $e) {
                throw new BaseException($e->getMessage());
        }
    }

    private function addRoute($route)
    {
        $desc = $route['desc'] ?? '';
        $method = $route['method'] ?? 'get';
        $filter = $route['filter'] ?? '';
        $object = $route['obj'] ?? '';
        $version = $route['version'] ?? '';
		$key = $route['path'].'_'.$route['method'];
        $this->routes[$key]['component'] = $route['component'];
        $this->routes[$key]['desc'] = $desc;
        $this->routes[$key]['method'] = $method;
        $this->routes[$key]['filter'] = $filter;
        $this->routes[$key]['obj'] = $object;
        $this->routes[$key]['version'] = $version;
        $this->routes[$key]['path'] = $route['path'];
        $this->routes[$key]['api_path'] = stripslashes($route['path']);
    }

	private function __clone()
	{
	}

	private function __wakeup()
	{
	}

}