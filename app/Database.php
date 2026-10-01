<?php

namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    private static ?Capsule $capsule = null;

    public static function boot(): void
    {
        if (self::$capsule !== null) {
            return;
        }

        $config = require __DIR__ . '/../config.php';
        $db = $config['db'];

        $capsule = new Capsule();
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => $db['host'],
            'port' => $db['port'],
            'database' => $db['name'],
            'username' => $db['user'],
            'password' => $db['pass'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        self::$capsule = $capsule;
    }
}
