<?php

return 'create table if not EXISTS daysOfWeek (
        id integer unsigned auto_increment primary key,
        name char(50),
        UNIQUE KEY (name),
        created_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';