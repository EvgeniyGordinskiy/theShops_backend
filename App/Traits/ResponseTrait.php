<?php

namespace App\Traits;


use App\Services\Http\Response\Response;
use App\Services\Hypermedia\Hal\Hal;
use App\Services\Hypermedia\Hypermedia;
use App\Services\Route\Route;

trait ResponseTrait
{

	public static function setPagination($currentPage, $lastPage, $limit, $totalCount)
    {
        Hal::$pagination['current_page'] = $currentPage;
        Hal::$pagination['last_page'] = $lastPage;
        Hal::$pagination['limit'] = $limit;
        Hal::$pagination['total_count'] = $totalCount;
    }
    
    /**
	 * @param array $items
	 * @param int $status
	 */
    public function send(array $items = [], $status = 200, $error = false)
    {
	    if ( $error ) {
		    $message['error'] = $items['error'] ?? '';
	    }
        $message['_links']['self']['href'] = $_SERVER['REQUEST_URI'];
        $message['_links']['currentlyProcessing'] = count($items);
        if(count(Hal::$pagination)) {
            $message['_links']['paginate']['current_page'] =  Hal::$pagination['current_page'];
            $message['_links']['paginate']['last_page'] =  Hal::$pagination['last_page'];
            $message['_links']['paginate']['limit'] =  Hal::$pagination['limit'];
            $message['_links']['paginate']['total_count'] =  Hal::$pagination['total_count'];
        }
        $message['_links']['items'] = $items;
        $hypermedia = new Hal();
        $message['_embedded'] = $this->_makeHypermedia($hypermedia);
        $response = new Response();
        $response->setStatusCode($status);
        $response->write($message);
        $response->send();
	    exit();
    }

	/**
	 * @param Hypermedia $hypermedia
	 * @return array
	 */
    protected function _makeHypermedia(Hypermedia $hypermedia)
    {
        $class = basename(str_replace('\\','/',get_class($this)));
	    $links = $hypermedia->create($class);
        return $links;
    }

	/**
	 * @param string $msg
	 * @param int $status
	 * @param int $key
	 */
    public function sendWithError(string $msg = '', $status = 500, $key = 0)
    {
	    if($key) $msg = [$key => $msg];
	    $msg ? $this->send(['error' => $msg],$status, true) : $this->send([],$status, true);
    }
}