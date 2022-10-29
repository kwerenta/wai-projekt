<?php

namespace app\controllers;

class BaseController extends ApplicationController
{
    public function index() {
        $this->view->addData(["name" => "Świecie"]);
    }
}