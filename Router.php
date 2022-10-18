<?php

namespace app;

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = __DIR__ . "/config/routes.yaml";
        $this->routes = yaml_parse_file($routesPath);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function resolveRoute(): bool
    {
        foreach ($this->getRoutes() as $route) {
            $method = $_SERVER["REQUEST_METHOD"];
            $path = explode("?", $_SERVER["REQUEST_URI"])[0];

            if ($route["path"] == $path && $method == ($route["method"] ?? "GET")) {
                $controllerEntry = explode("::", $route["controller"]);

                $controllerClass = "app\controllers\\" . $controllerEntry[0];
                $controllerAction = $controllerEntry[1];

                Application::$app->controller = new $controllerClass;
                Application::$app->controller->$controllerAction();

                Application::$app->view->render($controllerAction);
                return true;
            }
        }
        return false;
    }
}
