<?php
namespace App\versions\v1\schedule;

use App\Services\Model\Model;
use App\Services\DB\DB;
use App\versions\v1\scheduleHistory\ScheduleHistoryModel;
use Carbon\Carbon;

class ScheduleModel extends Model
{
    
    CONST SUFFIX_END = '_end';
    CONST SUFFIX_START = '_start';

    public static function getSchedule($shopId)
    {
        $schedules = DB::select('select day_of_week_id, time_open, time_close 
								  from schedules 
								   where shop_id ='.$shopId);
        return array_reduce($schedules, function ($schedule, $item) {
            $schedule[$item['day_of_week_id']]['start'] = $item['time_open'];
            $schedule[$item['day_of_week_id']]['end'] = $item['time_close'];
            return $schedule;
        });
    }

    public static function update(int $shopId, array $newSchedule)
    {
        $values = [];
        $values[':shop_id'] = $shopId;
        
        foreach ($newSchedule as &$day) {
            $day['start'] = $day['start'] ? $day['start'] : null;
            $day['end'] = $day['end'] ? $day['end'] : null;
            
            $sql = "
            insert into schedules 
               (shop_id, day_of_week_id, time_open, time_close)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE time_open = VALUES(time_open), time_close = VALUES(time_close)
                ";

            DB::execute($sql, [$shopId, $day['id'], $day['start'], $day['end']]);
        }
        
        ScheduleHistoryModel::insert($shopId, $newSchedule);

        return self::getSchedule($shopId);
    }
}