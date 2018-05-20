<?php
namespace App\Services\Http\Request;

use Zend\Diactoros\Request;

class SendRequest
{

	public function __construct()
	{
		$this -> _createRequest();
	}

	protected function _createRequest()
	{
		return 	new Request();
	}
}