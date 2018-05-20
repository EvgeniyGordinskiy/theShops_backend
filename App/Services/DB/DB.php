<?php
namespace App\Services\DB;

use App\Services\DB\Connects\IConnect;
use App\Services\Exceptions\BaseException;
use PDO;

class DB {

	private static $_state;
	private static $_stmt;

	/**
	 * Initialize new PDO instance and set attributes. 
	 * DB constructor.
	 */
    private function __construct(IConnect $connect)
	{
        self::$_state = $connect->connect();
    }

	public static function execute(string $sql, array $params = null)
	{
		self::prepare($sql);
		if ($params) {
			return self::$_stmt->execute($params);
		} else {
			return self::$_stmt->execute();
		}

	}

	public static function select(string $sql, array $params = null)
	{
		self::prepare($sql);
		self::$_stmt->execute($params);
		return self::$_stmt->fetchAll(\PDO::FETCH_ASSOC);
	}


	public static function insert(string $sql, array $params)
	{
		self::prepare($sql);
		self::$_stmt->execute($params);
		return self::$_state->lastInsertId();
	}
	
	/**
	 * If !self::$_state,
	 * creating new instance of the connect current Data Base and create new self.
	 */
	public static function getState()
	{
		if (!self::$_state) {
			$connect = 'App\\Services\\DB\\Connects\\'.ucfirst(strtolower(env('DB_CONNECTION')));
			$connect = new $connect();
			new self($connect);
		}

		return self::$_state;
	}

    private static function prepare($sql = '')
	{
	   self::getState();

	    if ($sql){
	        try {
		        $stmt = self::$_state->prepare($sql);
		        self::$_stmt = $stmt;
		        return $stmt;
	        } catch (\PDOException $e) {
		        new BaseException($e->getMessage());
	        }
        }
        return false;
    }


	private function __clone()
	{
	}

	private function __wakeup()
	{
	}

	public function __call($method, $parameters = null)
	{
		if ( method_exists($this, $method) ) {
			$this->$method($parameters);
		}
	}
}