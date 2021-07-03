<?php

$credentials = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST'       => 'localhost',
    'DB_DATABASE'   => 'test',
    'DB_USERNAME'   => 'root',
    'DB_PASSWORD'   => '',
    'DB_PORT'       => '',
];

foreach ($credentials as $key => $value) {
    putenv("$key=$value");
}
?>