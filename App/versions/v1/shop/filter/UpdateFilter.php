<?php

namespace App\versions\v1\shop\filter;

use App\Contracts\Filter\AbstractFilter;

class UpdateFilter extends AbstractFilter
{
    public function run($parameters) : array
    {

        if(!isset($parameters['id']) || !$parameters['id'] || !$this->isExist('shops', 'id', $parameters['id'])) {
            throw new \InvalidArgumentException('The shop\'s with that id is not exist.');
        }

        if(!isset($parameters['name']) || !$parameters['name'] || !$this->isString($parameters['name'])) {
            throw new \InvalidArgumentException('The shop\'s name is incorrect');
        }


        if(!isset($parameters['description']) || !$parameters['description'] || !$this->isString($parameters['description'], 400)) {
            throw new \InvalidArgumentException('The shop\'s description is incorrect');
        }


        if(!isset($parameters['short_description']) || !$parameters['short_description'] ||  !$this->isString($parameters['short_description'], 250)) {
            throw new \InvalidArgumentException('The shop\'s short_description is incorrect');
        }
        
        if(isset($parameters['sunday_start']) && isset($parameters['sunday_end'])) {
            if( $parameters['sunday_start'] && $parameters['sunday_end']) {
                if (!$this->isTime($parameters['sunday_start'], $parameters['sunday_end'])) {
                    throw new \InvalidArgumentException('Invalid time format for sunday , should be fo example 24:59');
                }
            }
        } else {
            throw new \InvalidArgumentException('Sundays start\'s or end\'s time can\'t be empty');
        }

        if(isset($parameters['monday_start']) && isset($parameters['monday_end'])) {
            if($parameters['monday_start'] && $parameters['monday_end']) {
                if (!$this->isTime($parameters['monday_start'], $parameters['monday_end'])) {
                    throw new \InvalidArgumentException('Invalid time format for monday , should be fo example 24:59');
                }
            }
        } else {
            throw new \InvalidArgumentException('Monday\'s start\'s or end\'s time can\'t be empty');
        }
        
        if(isset($parameters['tuesday_start']) && isset($parameters['tuesday_end'])) {
            if($parameters['tuesday_start'] && $parameters['tuesday_end']) {
                if (!$this->isTime($parameters['tuesday_start'], $parameters['tuesday_end'])) {
                    throw new \InvalidArgumentException('Invalid time format for tuesday , should be fo example 24:59');
                }
            }
        } else {
            throw new \InvalidArgumentException('Tuesday\'s start\'s or end\'s time can\'t be empty');
        }
        
        if(isset($parameters['wednesday_start']) && isset($parameters['wednesday_end'])) {
            if($parameters['wednesday_start'] && $parameters['wednesday_end']) {
                if (!$this->isTime($parameters['wednesday_start'], $parameters['wednesday_end'])) {
                    throw new \InvalidArgumentException('Invalid time format for wednesday , should be fo example 24:59');
                }
            }
        } else {
            throw new \InvalidArgumentException('Wednesday\'s start\'s or end\'s time can\'t be empty');
        }
        
        if(isset($parameters['thursday_start']) && isset($parameters['thursday_end'])) {
            if($parameters['thursday_start'] && $parameters['thursday_end']) {
                if (!$this->isTime($parameters['thursday_start'], $parameters['thursday_end'])) {
                    throw new \InvalidArgumentException('Invalid time format for thursday , should be fo example 24:59');
                }
            }
        } else {
            throw new \InvalidArgumentException('Thursday\'s start\'s or end\'s time can\'t be empty');
        }
        
        if(isset($parameters['friday_start']) && isset($parameters['friday_end'])) {
            if($parameters['friday_start'] && $parameters['friday_end']) {
                if (!$this->isTime($parameters['friday_start'], $parameters['friday_end'])) {
                    throw new \InvalidArgumentException('Invalid time format for friday , should be fo example 24:59');
                }
            }
        } else {
            throw new \InvalidArgumentException('Friday\'s start\'s or end\'s time can\'t be empty');
        }
        
        if(isset($parameters['saturday_start']) && isset($parameters['saturday_end'])) {
            if($parameters['saturday_start'] && $parameters['saturday_end']) {
                if (!$this->isTime($parameters['saturday_start'], $parameters['saturday_end'])) {
                    throw new \InvalidArgumentException('Invalid time format for saturday , should be fo example 24:59');
                }
            }
        } else {
            throw new \InvalidArgumentException('Saturday\'s start\'s or end\'s time can\'t be empty');
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