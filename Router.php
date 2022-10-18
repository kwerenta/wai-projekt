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
            $path = trim(explode("?", $_SERVER["REQUEST_URI"])[0], "/");

            if (trim($route["path"], "/") == $path && $method == ($route["method"] ?? "GET")) {
                [$controllerClassName, $controllerAction] = explode("::", $route["controller"]);

                $controllerClass = "app\controllers\\" . $controllerClassName;

                $controllerNamespace = substr($controllerClassName, 0, strrpos($controllerClassName, "\\"));
                if (!empty($controllerNamespace)) {
                    $controllerNamespace = str_replace("\\", "/", $controllerNamespace);
                    $controllerNamespace .= "/";
                }

                Application::$app->controller = new $controllerClass;
                Application::$app->controller->$controllerAction();

                Application::$app->view->render($controllerNamespace . $controllerAction);
                return true;
            }
        }
        return false;
    }
}
