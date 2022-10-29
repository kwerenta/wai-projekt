<?php

namespace app\controllers;

use app\View;

class ApplicationController
{
    protected $layout = "application";
    protected $params;
    public $view;

    public function __construct($params)
    {
        $this->view = new View($this->layout);
        $this->params = $params;
    }


}