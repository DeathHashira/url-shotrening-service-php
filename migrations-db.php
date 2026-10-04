<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

return [
    'dbname' => $_ENV["DB_NAME"],
    'user' => $_ENV["DB_USER"],
    'password' => $_ENV["DB_PASSWORD"],
    'host' => $_ENV["DB_HOST"],
    'driver' => $_ENV["DB_DRIVER"],
];