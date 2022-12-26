<?php

namespace app;

class Router
{
    private $routes;
    private $currentRoute;
    private $params = [];

    public function __construct()
    {
        $routesPath = __DIR__ . "/config/routes.yaml";
        $this->routes = yaml_parse_file($routesPath);
    }

    public function getCurrentRoute()
    {
        return $this->currentRoute;
    }

    public function getPath($routeName, $params = []): string
    {
        foreach ($this->routes as $name => $route) {
            if ($routeName == $name) {
                $url = $route["path"];

                foreach ($params as $key => $value) {
                    $url = str_replace(sprintf("{%s}", $key), $value, $url);
                }
                return $url;
            }
        }
        return "#";
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function resolveRoute(): bool
    {
        foreach ($this->routes as $route) {
            $path = trim(explode("?", $_SERVER["REQUEST_URI"])[0], "/");
            $route["path"] = trim($route["path"], "/");

            if ($this->comparePaths($path, $route["path"], $route["method"] ?? "GET")) {
                $this->currentRoute = $route;

                $explodedController = explode("::", $route["controller"]);
                $class = $explodedController[0];
                $action = $explodedController[1];

                $namespace = substr($class, 0, strrpos($class, "\\"));

                $this->currentRoute["controller"] = compact("class", "action", "namespace");
                return true;
            }
        }
        return false;
    }

    private function comparePaths($sourcePath, $targetPath, $method): bool
    {
        if (strcasecmp($_SERVER["REQUEST_METHOD"], $method) != 0) return false;
        if ($sourcePath == $targetPath) return true;

        $explodedSourcePath = explode("/", $sourcePath);
        $explodedTargetPath = explode("/", $targetPath);

        if (count($explodedSourcePath) != count($explodedTargetPath)) return false;

        foreach (array_combine($explodedSourcePath, $explodedTargetPath) as $sourceSegment => $targetSegment) {
            if ($this->isParam($targetSegment)) {
                $this->params[substr($targetSegment, 1, strlen($targetSegment) - 2)] = $sourceSegment;
                continue;
            }
            if ($sourceSegment != $targetSegment) {
                $this->params = [];
                return false;
            }
        }

        return true;
    }

    private function isParam($segment): bool
    {
        return !empty($segment) && $segment[0] == "{" && $segment[strlen($segment) - 1] == "}";
    }
}
