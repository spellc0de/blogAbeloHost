<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Http\Router;

Database::boot();

$config = require __DIR__ . '/../config.php';

$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/../templates');
$smarty->setCompileDir(__DIR__ . '/../templates_c');
$smarty->setCacheDir(__DIR__ . '/../cache');

$router = new Router();
require __DIR__ . '/../routes/web.php';

$router->dispatch($_SERVER['REQUEST_URI']);
