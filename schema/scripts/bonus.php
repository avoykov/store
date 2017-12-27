<?php
/**
 * Contains definition of bonus table.
 */

return [
    'weight' => 1,
    'queries' => [
        "CREATE TABLE IF NOT EXISTS bonuses (
          id SERIAL PRIMARY KEY,
          discount CHAR(2) NOT NULL
        )",
        "INSERT INTO bonuses (id, discount) 
          VALUES 
          (11111111, '10'),
          (22222222, '20'),
          (33333333, '30')
          "
    ]
];