<?php
namespace App\Services\Http\Request;

use Zend\Diactoros\ServerRequestFactory;

class Request
{
	// Zend\Diactoros\ServerRequest instance
    public $server;

	/**
	 * Request constructor.
	 */
	public function __construct()
	{
		$this->_getServerRequest();
	}

	/**
	 * Create instance of ServerRequest and saving to the property server
	 */
	protected function _getServerRequest()
	{
		$this->server = ServerRequestFactory::fromGlobals();
	}

	/**
	 * Allowing us get property of ServerRequest,
	 * without using public property server.
	 * 
	 * @param string $property
	 * @return null|string
	 */
	public function __get(string $property)
	{
		$params = $this->server->getQueryParams();
		if (array_key_exists($property, $params)) {
			return $params[$property];
		}
		return null;
	}

	/**
	 * Check if reauest method is post
	 * @return bool
	 */
	public static function isPost(): bool
	{
		return $_SERVER['REQUEST_METHOD'] === 'POST';
	}

	/**
	 * Check if reauest method is put
	 * @return bool
	 */
	public static function isPut(): bool
	{
		return $_SERVER['REQUEST_METHOD'] === 'PUT';
	}

	/**
	 * Get values
	 * @return bool|mixed
	 */
	public static function getValues()
	{
		if(self::isPost() || self::isPut()) {
//			parse_str(file_get_contents("php://input"), $input);
			$input = (array) json_decode(file_get_contents("php://input"));

			if ($input) {
				return $input;
			}
		} else {
			return $_GET;
		}
	}
}