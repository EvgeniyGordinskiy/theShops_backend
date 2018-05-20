<?php

return '
        create table if not EXISTS migrations (
            id INTEGER auto_increment PRIMARY KEY, 
            name VARCHAR(255)
        )
        ';