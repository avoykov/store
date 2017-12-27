#Description
Basic MVC framework + basic store implementation conform test requirements.

#Installation
0) Standard actions related to any web project;
1) Run composer install
21) Enter all needed data to - config/* (mostly database file);
3) Go to schema folder;
4) Run php run.php
5) Profit

#Framework
#####Was developed basic MVC framework.

#####List of implemented features:
1) Base routing (including params in routes and support of controllers);
2) PDO decorator;
3) Base model and api for working with models;
4) Mechanism for defining database structure;
5) Base view system;
6) CSRF protection (inside Request);
7) XSS and sql-injection protection(inside Request + pdo placeholders);
8) Base session wrapper.

## What wasn't implemented:
1) Workers for processing orders;
