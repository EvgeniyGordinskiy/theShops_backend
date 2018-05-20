<?php

namespace App\Services\Exceptions;

use App\Services\Http\Response\Response;
use App\Services\Log\Log;
use App\Traits\ResponseTrait;

class BaseException extends \RuntimeException
{
	use ResponseTrait;
	/**
	 * BaseException constructor. Send headers with message and status.
	 * @param string|null $message
	 */
	public function __construct (string $message = null, $status_code = 500)
	{
		$message = ucfirst(strtolower($message));
        new Log($this, $message);
		$this->sendWithError($message, $status_code);
    }
}