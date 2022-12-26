<?php

namespace app\controllers;

use app\View;

class ApplicationController
{
    protected $layout = "application";
    protected $params;
    private $namespace;
    public $view;

    public function __construct($namespace, $action, $params)
    {
        $this->namespace = $namespace;
        $this->view = new View($this->namespace . "/" . $action, $this->layout);
        $this->params = $params;
    }
}
