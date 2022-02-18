<?php
return [
    'db' => [
        'connection' => [
            'default' => [
                'host' => 'localhost',
                'dbname' => 'tubee',
                'username' => 'tubee',
                'password' => '123456',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
                'active' => '1',
                'driver_options' => [
                    1014 => false
                ]
            ]
        ],
        'table_prefix' => ''
    ],
    'public' => '/home/dylan/youtube-dl/tubee-server/public',
    'static' => '/home/dylan/youtube-dl/tubee-server/public/static'
];
