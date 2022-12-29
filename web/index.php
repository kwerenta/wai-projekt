<?php
require_once "../vendor/autoload.php";

require_once "../config/paths.php";
require_once "../config/db.php";

use app\Application;

$app = new Application();
$app->start();
