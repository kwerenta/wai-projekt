<?php

namespace app\controllers;

use app\View;

class ApplicationController
{
    protected $layout = "application";
    protected $params;
    public $view;

    public function __construct($namespace, $action, $params)
    {
        $this->view = new View($namespace . "/" . $action, $this->layout);
        $this->params = $params;
    }

    protected function validateRequiredFields($fields)
    {
        foreach ($fields as $field) {
            if (empty($_POST[$field]))
                return false;
        }
        return true;
    }
}
