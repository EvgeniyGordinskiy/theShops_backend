<?php
namespace App\versions\v1\dayOfWeek;

use App\Services\Model\Model;
use App\Services\DB\DB;
use Carbon\Carbon;

class DayWeekModel extends Model
{
    public static function getDays()
    {
        return  array_reduce(DB::select('select id, name from daysOfWeek'), function ($days, $item) {
            $days[$item['name']] = $item['id'];
            return $days;
        });
    }

    public static function getDayByName($name)
    {
        return DB::select("select id from daysOfWeek where name = '$name'")[0]['id'];
    }
}