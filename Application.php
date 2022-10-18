<?php

namespace app;

class Application
{
    public static $app;
    public $router;
    public $db;
    public $view;
    public $controller = null;

    public function __construct()
    {
        self::$app = $this;

        $this->router = new Router();
        $this->db = new Database([]);
        $this->view = new View();
    }
}