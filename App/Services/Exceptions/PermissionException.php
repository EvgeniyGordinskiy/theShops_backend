<?php

namespace App\Services\Exceptions;

class PermissionException extends BaseException
{
	public function __construct($message = false, $code = 403)
	{
		parent::__construct($message, $code);
	}
}