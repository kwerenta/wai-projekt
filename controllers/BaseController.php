<?php

namespace app\controllers;

class BaseController extends ApplicationController
{
    public function index($view) {
        $view->addData(["name" => "Świecie"]);
    }
}