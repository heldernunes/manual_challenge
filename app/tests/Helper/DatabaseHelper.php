<?php

namespace App\Tests\Helper;

class DatabaseHelper
{
    public static function getDBConfig()
    {
        return [
            'use_savepoints' => true,
            'driver' => 'pdo_sqlite',
            'host' => 'localhost',
            'port' => null,
            'user' => 'root',
            'password' => null,
            'driverOptions' => [],
            'defaultTableOptions' => [],
            'path' => '/var/www/html/var/data.db',
        ];
    }
}
