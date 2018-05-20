<?php

namespace App\Traits;


use App\Services\Http\Response\Response;
use App\Services\Hypermedia\Hal\Hal;
use App\Services\Hypermedia\Hypermedia;
use App\Services\Route\Route;

trait ResponseTrait
{

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
	 */
    public function sendWithError(string $msg = '', $status = 500)
    {
	    $msg?$this->send(['error' => $msg],$status, true):$this->send([],$status, true);
    }
}