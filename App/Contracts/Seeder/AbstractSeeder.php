<?php
namespace App\Contracts\Seeder;

abstract class AbstractSeeder implements SeederInterface
{
    public $faker;

    public function  __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    protected function getCount()
    {
        return $this->count ?? self::COUNT;
    }
}