<?php

namespace app\controllers;

use app\View;

class ApplicationController
{
    protected $layout = "application";
    public $view;

    public function __construct()
    {
        $this->view = new View($this->layout);
    }


}