<?php
namespace App\Services\Log;

use \App\Services\FileSystem\File;

class Log
{

	/**
	 * Log constructor. Writing message to the file.
	 * @param \Exception $exception
	 * @param string $body
	 * @param string $file
	 * @param number $line
	 */
	public function __construct($exception = false, $body = '', $file = '', $line = 0)
	{
		if ( !$body ) {
			$body = $exception->getMessage();
		}

		if ( !$file ) {
			$file = $exception->getFile();
		}

		if ( !$line ) {
			$line = $exception->getLine();
		}
		$trace = "\n";

		if ( $exception && $exception instanceof \Exception) {
			$trace = '\n '.$exception->getTraceAsString()." \n ";
		}

		$message = date('Y-m-d H:i:s')." $body in file $file on line $line $trace";

		if ($path = config('app', 'log')['path']) {
			$data = date('dmY');
			$file = $path . DIRECTORY_SEPARATOR . $data . 'Log.php';
			$file = new File($file,'a');
			$file->fwrite($message);
		}
	}

}