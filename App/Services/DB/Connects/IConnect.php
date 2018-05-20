<?php
namespace App\Services\DB\Connects;

interface IConnect
{
    /**
     * Connect to custom Data Base
     * @return mixed
     */
    public function connect();
}