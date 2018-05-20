<?php
namespace App\Contracts\Filter;

use App\Services\DB\DB;

abstract class AbstractFilter implements IFilter
{
    public function isString($value, $length = 0)
    {
        if($length) {
            return $value ?
                is_string($value) && (mb_strlen($value, 'utf8') < $length) :
                false;
        }
        return $value ?  is_string($value) : false;
    }
    
    public function isTime($startTime, $endTime)
    {
        if($startTime === $endTime) return false;

        $partialsStart = explode(':', $startTime);
        $partialsSEnd = explode(':', $endTime);
       if(count($partialsStart) < 2 || count($partialsSEnd) < 2) return false;
        if(intval($partialsStart[0]) <=  intval($partialsSEnd[0])) {
            if(intval($partialsStart[0]) ===  intval($partialsSEnd[0]) &&
                intval($partialsStart[1]) >=  intval($partialsSEnd[1])) {
                return false;
            }

            return $this->parseTime($startTime) && $this->parseTime($endTime);
        }
        return false;
    }
    
    public function isExist($table, $key, $value)
    {
        return DB::select("select $key from $table where $key = $value");
    }

    private function parseTime($time)
    {
        return preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $time);
    }
}