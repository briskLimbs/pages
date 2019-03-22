<?php

global $database;
$table = 'pages';
$columns = array(
    'id' => array('type' => 'int(1)', 'special' => 'primary'),
    'title' => array('type' => 'varchar(255)', 'special' => 'NOT NULL'),
    'slug' => array('type' => 'varchar(45)', 'special' => 'NOT NULL'),
    'content' => array('type' => 'text', 'special' => 'NOT NULL'),
    'published' => array('type' => 'datetime', 'special' => 'DEFAULT CURRENT_TIMESTAMP'),
    'status' => array('type' => 'enum("active","inactive")', 'special' => 'NOT NULL')
  );

$database->createTable($table, $columns);