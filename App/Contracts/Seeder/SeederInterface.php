<?php
namespace App\Contracts\Seeder;

interface SeederInterface
{
    const COUNT = 5;
    
    public function run();
}