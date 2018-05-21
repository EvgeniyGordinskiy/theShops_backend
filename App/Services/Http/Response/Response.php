<?php
namespace App\Services\Http\Response;

class Response
{
	// \Zend\Diactoros\Response instance
	public $server;

	protected $headers = [
	'Access-Control-Allow-Origin'      => 'http://localhost:8080',
	'Access-Control-Allow-Methods'     => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
	'Access-Control-Allow-Headers'     => 'Content-Type, Accept, Authorization, X-Requested-With, Application',
	'Access-Control-Allow-Credentials' => 'true',
	];

	/**
	 * Response constructor.
	 */
	public function __construct()
	{
		$this ->_createResponse();
	}

	/**
	 * Create instance of \Zend\Diactoros\Response and saving to the property server
	 */
	protected function _createResponse()
	{
		$this->server = new \Zend\Diactoros\Response($body = 'php://memory', $status = 200, $this->headers);
	}

	/**
	 * @param int $code
	 */
	public function setStatusCode(int $code)
	{
		$this->server = $this->server->withStatus($code);
	}

	/**
	 * Write body of the response
	 * @param $data
	 */
	public function write($data)
	{
		$this->server->getBody()->write(json_encode($data));
	}

	/**
	 * Send Response
	 * @param bool $msg
	 */
	public function send($msg = false)
	{
		$status = $this->server->getStatusCode();
		http_response_code($status);
		if ( $headers = $this->server->getHeaders() ) {
			foreach ($headers as $key => $value) {
				header("$key:$value[0]");
			}
		}
		
		$this->server->getBody()->rewind();
		$content = $this->server->getBody()->getContents();
		if ( $content ) {
			header_remove('Content-type');
			header('Content-type:application/json;charset=utf-8');
			echo $content;
		}
		if ($msg) {
			echo $msg;
		}
	}
}