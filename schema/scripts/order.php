<?php
/**
 * Contains definition of orders tables.
 */

return [
    'weight' => 2,
    'queries' => [
        "CREATE TABLE IF NOT EXISTS orders (
          id SERIAL PRIMARY KEY,
          name VARCHAR (255) NOT NULL,
          email VARCHAR (255) NOT NULL,
          phone VARCHAR (255) NOT NULL,
          card_number BIGINT NOT NULL,
          cvv INT NOT NULL,
          status BOOLEAN NOT NULL,
          bid INTEGER REFERENCES bonuses (id),
          created INTEGER,
          closed INTEGER,
          hash VARCHAR(64) DEFAULT NULL
        )",
        "CREATE TABLE IF NOT EXISTS order_items (
          id SERIAL PRIMARY KEY,
          oid INTEGER NOT NULL REFERENCES orders (id),
          pid INTEGER NOT NULL REFERENCES  products (id),
          quantity INT NOT NULL DEFAULT 1
        )"
    ]
];