<?php
namespace App\versions\v1\scheduleHistory;

use App\Services\Model\Model;
use App\Services\DB\DB;
use App\versions\v1\schedule\ScheduleModel;
use Carbon\Carbon;

class ScheduleHistoryModel extends Model
{
    CONST START_DAYS = 'sunday_start, monday_start, tuesday_start, wednesday_start,thursday_start, friday_start, saturday_start';
    CONST END_DAYS = 'sunday_end,  monday_end, tuesday_end, wednesday_end, thursday_end, friday_end, saturday_end';
    
    public static function insert($shopId, $schedule)
    {
        $values = [];
        $values[':shop_id'] = $shopId;
        
        foreach ($schedule as $weekDay => $day) {
            $values[":$weekDay".ScheduleModel::SUFFIX_START] = $day['start'];
            $values[":$weekDay".ScheduleModel::SUFFIX_END] = $day['end'];
        }

        $columns = implode(',',array_map(function($item){return ltrim($item, ':');}, array_keys($values)));
        $columnsVAl = implode(',', array_keys($values));
        return DB::insert("
            INSERT INTO `scheduleHistory` ($columns)
            VALUES ($columnsVAl)
            ", $values
        );
    }

    public static function get_open_shops_by_the_date($day = '', $time = '', $limit = 0, $page = 0)
    {
        $date = $day ? new Carbon($day) : new Carbon();
        $weekDay = config('app','days_of_week')[$date->dayOfWeek];
        $column = $weekDay.ScheduleModel::SUFFIX_START;

        $historyScheduleSql ="select shop_id, max(id) as id
							from scheduleHistory
							where created_at < '{$date->toDateString()}'
							group by shop_id
							";

        $historySchedule = DB::select($historyScheduleSql);

        $start_days = self::START_DAYS;
        $end_days   = self::END_DAYS;

        $ids = implode(',', array_column($historySchedule, 'id'));

        $resSql = "select id, shop_id, $start_days, $end_days
						from scheduleHistory
						where id in ($ids)
						";
        if($time) {
            foreach (explode(',',$start_days) as $key => $sDay) {
                if($key === 0) {
                    $resSql .= " AND( $sDay <= '$time' ";

                } else if($key + 1 === count(explode(',',$start_days))){
                    $resSql .= " or $sDay <= '$time' )";

                } else {
                    $resSql .= " or $sDay <= '$time' ";
                }
            }

            foreach (explode(',',$end_days) as $key => $eDay) {
                if($key === 0) {
                    $resSql .= " AND( $eDay >= '$time' ";

                } else if($key + 1 === count(explode(',',$start_days))){
                    $resSql .= " or $eDay >= '$time' )";

                } else {
                    $resSql .= " or $eDay >= '$time' ";
                }
            }
        }

        if($day) $resSql .= " AND $column is not NULL ";

        if($limit) $resSql .= " limit $limit ";

        if($page) {
            $offs = ($page - 1)*$limit;
            $resSql .= " offset $offs";
        }

        return DB::select($resSql);
    }
}