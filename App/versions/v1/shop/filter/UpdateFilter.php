<?php

namespace App\versions\v1\shop\filter;

use App\Contracts\Filter\AbstractFilter;

class UpdateFilter extends AbstractFilter
{
    public function run($parameters) : array
    {
        if(!isset($parameters['id']) || !$parameters['id'] || !$this->isExist('shops', 'id', $parameters['id'])) {
            $this->sendWithError('The shop\'s with that id is not exist.', 400, 'shop_id');
        }

        if(!isset($parameters['name']) || !$parameters['name'] || !$this->isString($parameters['name'])) {
            $this->sendWithError('The shop\'s name is incorrect', 400, 'name');
        }


        if(!isset($parameters['description']) || !$parameters['description'] || !$this->isString($parameters['description'], 400)) {
            $this->sendWithError('The shop\'s description is incorrect', 400, 'description');
        }


        if(!isset($parameters['short_description']) || !$parameters['short_description'] ||  !$this->isString($parameters['short_description'], 250)) {
            $this->sendWithError('The shop\'s short_description is incorrect', 400, 'short_description');
        }
        
        if(isset($parameters['sunday_start']) && isset($parameters['sunday_end'])) {
            if( $parameters['sunday_start'] || $parameters['sunday_end']) {
                if (!$this->isTime($parameters['sunday_start'], $parameters['sunday_end'])) {
                    $this->sendWithError('Invalid time format for sunday.', 400, 'sunday_start');
                }
            }
        } else {
            $this->sendWithError('Sundays start\'s or end\'s time can\'t be empty', 400, 'sunday_start');
        }

        if(isset($parameters['monday_start']) && isset($parameters['monday_end'])) {
            if($parameters['monday_start'] || $parameters['monday_end']) {
                if (!$this->isTime($parameters['monday_start'], $parameters['monday_end'])) {
                    $this->sendWithError('Invalid time format for monday.', 400, 'monday_start');
                }
            }
        } else {
            $this->sendWithError('Monday\'s start\'s or end\'s time can\'t be empty', 400, 'monday_start');
        }
        
        if(isset($parameters['tuesday_start']) && isset($parameters['tuesday_end'])) {
            if($parameters['tuesday_start'] || $parameters['tuesday_end']) {
                if (!$this->isTime($parameters['tuesday_start'], $parameters['tuesday_end'])) {
                    $this->sendWithError('Invalid time format for tuesday.', 400, 'tuesday_start');
                }
            }
        } else {
            $this->sendWithError('Tuesday\'s start\'s or end\'s time can\'t be empty', 400, 'tuesday_start');
        }
        
        if(isset($parameters['wednesday_start']) && isset($parameters['wednesday_end'])) {
            if($parameters['wednesday_start'] || $parameters['wednesday_end']) {
                if (!$this->isTime($parameters['wednesday_start'], $parameters['wednesday_end'])) {
                    $this->sendWithError('Invalid time format for wednesday.', 400, 'wednesday_start');
                }
            }
        } else {
            $this->sendWithError('Wednesday\'s start\'s or end\'s time can\'t be empty', 400, 'wednesday_start');
        }
        
        if(isset($parameters['thursday_start']) && isset($parameters['thursday_end'])) {
            if($parameters['thursday_start'] || $parameters['thursday_end']) {
                if (!$this->isTime($parameters['thursday_start'], $parameters['thursday_end'])) {
                    $this->sendWithError('Invalid time format for thursday.', 400, 'thursday_start');
                }
            }
        } else {
            $this->sendWithError('Thursday\'s start\'s or end\'s time can\'t be empty', 400, 'thursday_start');
        }
        
        if(isset($parameters['friday_start']) && isset($parameters['friday_end'])) {
            if($parameters['friday_start'] || $parameters['friday_end']) {
                if (!$this->isTime($parameters['friday_start'], $parameters['friday_end'])) {
                    $this->sendWithError('Invalid time format for friday.', 400, 'friday_start');
                }
            }
        } else {
            $this->sendWithError('Friday\'s start\'s or end\'s time can\'t be empty', 400, 'friday_start');
        }
        
        if(isset($parameters['saturday_start']) && isset($parameters['saturday_end'])) {
            if($parameters['saturday_start'] || $parameters['saturday_end']) {
                if (!$this->isTime($parameters['saturday_start'], $parameters['saturday_end'])) {
                    $this->sendWithError('Invalid time format for saturday.', 400, 'saturday_start');
                }
            }
        } else {
            $this->sendWithError('Saturday\'s start\'s or end\'s time can\'t be empty', 400, 'saturday_start');
        }

        return  [
            $parameters['id'],
            $parameters['name'],
            $parameters['description'],
            $parameters['short_description'],
            $parameters['sunday_start'],
            $parameters['sunday_end'],
            $parameters['monday_start'],
            $parameters['monday_end'],
            $parameters['tuesday_start'],
            $parameters['tuesday_end'],
            $parameters['wednesday_start'],
            $parameters['wednesday_end'],
            $parameters['thursday_start'],
            $parameters['thursday_end'],
            $parameters['friday_start'],
            $parameters['friday_end'],
            $parameters['saturday_start'],
            $parameters['saturday_end'],
        ];
    }
}