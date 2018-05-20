<?php
namespace database\seeds;

use App\Contracts\Seeder\AbstractSeeder;
use App\Services\DB\DB;
use  \App\versions\v1\dayOfWeek\DayWeekModel;
use App\versions\v1\schedule\ScheduleModel;

class SchedulesSeeder extends AbstractSeeder
{
    public $count = 10;

    private $shopIds = [];

    public function __construct(array $shopIds)
    {
        $this->shopIds = $shopIds;
        parent::__construct();
    }

    public function run()
    {
        $hours = range(0, 16);
        foreach ($this->shopIds as $shopId) {
            $values[':shop_id'] = $shopId;
            $daysWeek = DayWeekModel::getDays();
            foreach ($daysWeek as $day => $dayId) {
                $time_open = array_rand($hours) . ':00';
                $time_close = array_rand($hours) + 8 . ':00';
                
                DB::insert("
                    INSERT INTO `schedules`
                      (shop_id , day_of_week_id, time_open, time_close)
                    VALUES (?, ?, ?, ?)
                    ", [$shopId, $dayId, $time_open, $time_close]
                );
                
                $values[":$day".ScheduleModel::SUFFIX_START] = $time_open;
                $values[":$day".ScheduleModel::SUFFIX_END] = $time_close;
            }

            $columns = implode(',',array_map(function($item){return ltrim($item, ':');}, array_keys($values)));
            $columnsVAl = implode(',', array_keys($values));
            DB::insert("
            INSERT INTO `scheduleHistory` ($columns)
            VALUES ($columnsVAl)
            ", $values
            );
            
        }
    }

}

