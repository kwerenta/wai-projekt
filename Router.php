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

    public function getPath($routeName, $params = []): string {
        foreach ($this->getRoutes() as $name => $route) {
            if($routeName == $name) {
                $url = $route["path"];

                foreach ($params as $key => $value){
                    $url = str_replace("{{$key}}", $value ,$url);
                }
                return $url;
            }
        }
        return "#";
    }

    public function resolveRoute(): bool
    {
        foreach ($this->getRoutes() as $route) {
            $method = $_SERVER["REQUEST_METHOD"];
            $path = trim(explode("?", $_SERVER["REQUEST_URI"])[0], "/");

            if (trim($route["path"], "/") == $path && $method == ($route["method"] ?? "GET")) {
                [$controllerClassName, $controllerAction] = explode("::", $route["controller"]);

                $controllerClass = "app\controllers\\" . $controllerClassName;

                Application::$app->controller = new $controllerClass;
                Application::$app->controller->$controllerAction();
                return true;
            }
        }
        return false;
    }
}
