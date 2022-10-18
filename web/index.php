<?php
require_once "../vendor/autoload.php";

use app\Application;

$app = new Application();

$app->router->resolveRoute();

echo "<h1>WAI - development</h1>";
