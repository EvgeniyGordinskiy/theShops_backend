<?php
namespace database\seeds;

use App\Contracts\Seeder\AbstractSeeder;
use App\Services\DB\DB;

class ShopSeeder extends AbstractSeeder
{
    public $count = 10;
    protected $idShops = []; 
    
    public function run()
    {
        
        foreach (range(0, $this->getCount()) as $item) {
           $this->idShops[] = DB::insert("
                INSERT INTO `shops`
                  (name , description, short_description)
                VALUES (?, ?, ?)
                ", [$this->faker->company, $this->faker->sentence(25), $this->faker->sentence()]
            );
        }

        (new SchedulesSeeder($this->idShops))->run();
    }
  
}

