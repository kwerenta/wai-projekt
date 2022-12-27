<?php
require_once "../vendor/autoload.php";

define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);
define("IMAGES_PATH", ROOT_PATH . "/images/");

use app\Application;

$app = new Application();
$app->start();
