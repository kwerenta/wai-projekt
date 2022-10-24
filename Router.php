<?php

namespace app;

class Router
{
    private $routes;
    private $currentRoute;

    public function __construct()
    {
        $routesPath = __DIR__ . "/config/routes.yaml";
        $this->routes = yaml_parse_file($routesPath);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getCurrentRoute() {
        return $this->currentRoute;
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
                $this->currentRoute = $route;
                [$class, $action] = explode("::", $route["controller"]);

                $namespace = substr($class, 0, strrpos($class, "\\"));

                $this->currentRoute["controller"] = compact("class", "action", "namespace");
                return true;
            }
        }
        return false;
    }
}
