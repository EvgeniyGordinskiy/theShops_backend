<?php
namespace App\Services\Controller;

use App\Traits\HttpApi;

abstract class BaseController
{
    /**
     * Work with Request/Response
     */
    use HttpApi;

    /**
     * Instance by Filter,  which is defined in the Route.php
     * @var
     */
    public $filter;
}