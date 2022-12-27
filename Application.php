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

        session_start();
    }

    public function start()
    {
        if ($this->router->resolveRoute()) {
            $controller = $this->router->getCurrentRoute()["controller"];

            $controllerClass = "app\controllers\\" . $controller["class"];
            $action = $controller["action"];

            $this->controller = new $controllerClass($controller["namespace"], $action, $this->router->getParams());
            $this->controller->$action();

            if (strcasecmp($this->router->getCurrentRoute()["method"] ?? "GET", "GET") == 0)
                echo $this->controller->view->render();
            else
                echo "This is not GET request.";
        } else {
            echo "<h1>Page not found.</h1>";
        }
    }
}
