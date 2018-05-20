<?php

return 'create table if not EXISTS shops (
        id integer unsigned auto_increment primary key,
        name varchar(255),
        description text,
        short_description text,
        created_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);';