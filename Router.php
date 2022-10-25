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

    public function getCurrentRoute() {
        return $this->currentRoute;
    }

    public function getPath($routeName, $params = []): string {
        foreach ($this->routes as $name => $route) {
            if($routeName == $name) {
                $url = $route["path"];

                foreach ($params as $key => $value){
                    $url = str_replace(sprintf("{%s}", $key), $value ,$url);
                }
                return $url;
            }
        }
        return "#";
    }

    public function resolveRoute(): bool
    {
        foreach ($this->routes as $route) {
            $path = trim(explode("?", $_SERVER["REQUEST_URI"])[0], "/");
            $route["path"] = trim($route["path"], "/");

            if ($this->comparePaths($path, $route["path"], $route["method"] ?? "GET")) {
                $this->currentRoute = $route;
                [$class, $action] = explode("::", $route["controller"]);

                $namespace = substr($class, 0, strrpos($class, "\\"));

                $this->currentRoute["controller"] = compact("class", "action", "namespace");
                return true;
            }
        }
        return false;
    }

    private function comparePaths($sourcePath, $targetPath, $method): bool {
        if($_SERVER["REQUEST_METHOD"] != $method) return false;
        if($sourcePath == $targetPath) return true;

        $explodedSourcePath = explode("/", $sourcePath);
        $explodedTargetPath = explode("/", $targetPath);

        if(count($explodedSourcePath) != count($explodedTargetPath)) return false;

        foreach (array_combine($explodedSourcePath, $explodedTargetPath) as $source => $target) {
            if(!($source == $target || (!empty($target) && $target[0] == "{" && $target[-1] == "}"))) return false;
        }

        return true;
    }
}
