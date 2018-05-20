<?php
namespace database\seeds;

use App\Contracts\Seeder\AbstractSeeder;
use App\Services\DB\DB;

class DaysOfWeekSeeder extends AbstractSeeder
{
    public $week = [
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday'
    ];
    
    public function run()
    {
        foreach ($this->week as $day) {
           try{
               DB::insert("
                INSERT INTO `daysOfWeek` 
                  (name)
                VALUES (?)  
                ", [$day]);
           } catch (\Exception $e) {
               
           }
         
        }    
    }
}