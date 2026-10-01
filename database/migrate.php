<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Database::boot();

$schema = Capsule::schema();

if (!$schema->hasTable('migrations')) {
    $schema->create('migrations', function (Blueprint $table) {
        $table->increments('id');
        $table->string('migration');
        $table->unsignedInteger('batch');
    });
}

$direction = $argv[1] ?? 'up';
$applied = Capsule::table('migrations')->pluck('migration')->all();
$files = glob(__DIR__ . '/migrations/*.php');
sort($files);

if ($direction === 'down') {
    $lastBatch = (int) Capsule::table('migrations')->max('batch');

    if ($lastBatch === 0) {
        echo "Нет применённых миграций\n";
        exit;
    }

    $toRollback = Capsule::table('migrations')->where('batch', $lastBatch)->pluck('migration');

    foreach (array_reverse($files) as $file) {
        $name = basename($file, '.php');

        if (!$toRollback->contains($name)) {
            continue;
        }

        (require $file)->down();
        Capsule::table('migrations')->where('migration', $name)->delete();
        echo "Откачано: {$name}\n";
    }

    exit;
}

$batch = (int) Capsule::table('migrations')->max('batch') + 1;
$ran = 0;

foreach ($files as $file) {
    $name = basename($file, '.php');

    if (in_array($name, $applied, true)) {
        continue;
    }

    (require $file)->up();
    Capsule::table('migrations')->insert(['migration' => $name, 'batch' => $batch]);
    echo "Применено: {$name}\n";
    $ran++;
}

echo $ran > 0 ? "Готово, применено миграций: {$ran}\n" : "Все миграции уже применены\n";
