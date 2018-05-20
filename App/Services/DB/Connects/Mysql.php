<?php
namespace App\Services\DB\Connects;

use App\Services\Exceptions\BaseException;

class Mysql implements IConnect
{
    public function __construct()
    {
    }

    /**
     * Connect to the MySQL Data Base
     * @return \PDO
     */
    public function connect() : \PDO
    {
        try{
            $pdo = new \PDO(
                "mysql:host=".env('DB_HOST').";dbname=".env('DB_DATABASE'),
                env('DB_USERNAME'),
                env('DB_PASSWORD')
            );
            $pdo -> setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION
            );
            return $pdo;
        } catch (\PDOException $e) {
            new BaseException($e->getMessage());
        }
        return false;
    }
}