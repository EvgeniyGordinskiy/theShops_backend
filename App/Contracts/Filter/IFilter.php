<?php

namespace App\Contracts\Filter;

interface IFilter
{
    public function run($parameters) : array ;
}