<?php

return	'
        create table if not EXISTS scheduleHistory ( 
            id integer unsigned auto_increment primary key,
            shop_id integer unsigned,
            sunday_start TIME,
            sunday_end TIME,
            monday_start TIME,
            monday_end TIME,
            tuesday_start TIME,
            tuesday_end TIME,
            wednesday_start TIME,
            wednesday_end TIME,
            thursday_start TIME,
            thursday_end TIME,
            friday_start TIME,
            friday_end TIME,
            saturday_start TIME,
            saturday_end TIME,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
        ';