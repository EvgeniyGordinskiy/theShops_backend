<?php

namespace App\versions\v1\shop\filter;

use App\Contracts\Filter\AbstractFilter;
use Carbon\Carbon;

class IndexFilter extends AbstractFilter
{
	public function run($parameters) : array 
	{
		$date = '';
		if ( isset($parameters['date']) ) {
			$partials = explode('-',$parameters['date']);
			if(count($partials) === 3 && checkdate($partials[1],$partials[2], $partials[0])){
				$date = $parameters['date'];
			}else {
				throw new \InvalidArgumentException('Invalid date format, should be Y-m-d');
			}
		}

		$time = '';
		if ( isset($parameters['time']) ) {
			if(preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $parameters['time'])) {
				$time = $parameters['time'];
			}else {
				throw new \InvalidArgumentException('Invalid time format, should be fo example 24:59');
			}
		}

		$limit = '';
		if ( isset($parameters['limit']) && $parameters['limit']) {
			if(intval($parameters['limit'])) {
				$limit = $parameters['limit'];
			}else {
				throw new \InvalidArgumentException('Limit should be an integer');
			}
		}

		$page = '';
		if ( isset($parameters['page']) && $parameters['page']) {
			if(intval($parameters['page'])) {
				$page = $parameters['page'];
			}else {
				throw new \InvalidArgumentException('Page should be an integer');
			}
		}


		return  [$date, $time, $limit, $page];
	}
}