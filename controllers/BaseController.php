<?php

namespace app\controllers;

use app\Application;
use app\View;

class BaseController extends ApplicationController
{
    public function index() {
        Application::$app->view->render("index", ["name" => "Świecie"]);
    }
}