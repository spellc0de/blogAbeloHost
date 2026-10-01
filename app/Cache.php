<?php

namespace App;

use Predis\Client;

class Cache
{
    private static ?Client $client = null;

    public static function redis(): Client
    {
        if (self::$client !== null) {
            return self::$client;
        }

        $config = require __DIR__ . '/../config.php';

        self::$client = new Client([
            'scheme' => 'tcp',
            'host' => $config['redis']['host'],
            'port' => $config['redis']['port'],
        ]);

        return self::$client;
    }
}
