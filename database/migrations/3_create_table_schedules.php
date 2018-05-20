<?php

return
    'create table if not EXISTS schedules (
        id integer unsigned primary key auto_increment,
        shop_id integer unsigned,
        foreign key(shop_id) references shops(id)  on DELETE CASCADE ON UPDATE CASCADE,
        day_of_week_id integer unsigned,
        foreign key(day_of_week_id) references daysOfWeek(id) ON UPDATE CASCADE,
        time_open TIME,
        time_close TIME,
        UNIQUE KEY(shop_id,day_of_week_id),
        created_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';