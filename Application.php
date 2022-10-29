<?php

namespace app;

class Application
{
    public static $app;
    public $router;
    public $db;
    public $controller;

    public function __construct()
    {
        self::$app = $this;

        $this->router = new Router();
        $this->db = new Database([]);
    }

    public function start()
    {
        if ($this->router->resolveRoute()) {
            $controller = $this->router->getCurrentRoute()["controller"];

            $controllerClass = "app\controllers\\" . $controller["class"];
            $this->controller = new $controllerClass($this->router->getParams());

            $action = $controller["action"];
            $this->controller->$action();

            echo $this->controller->view->render($controller["namespace"] . "/" . $controller["action"]);
        } else {
            echo "<h1>Page not found.</h1>";
        }
    }
}