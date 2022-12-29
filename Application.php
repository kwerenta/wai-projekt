<?php

namespace app;

class Application
{
    public $router;
    public $controller;

    public function __construct()
    {
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

            echo $this->controller->view->render();
        } else {
            $notFoundView = new View("404", "404");
            echo $notFoundView->render();
        }
    }
}
