<?php

namespace app;

class View
{
    public function render($viewName) {
        $layoutName = Application::$app->controller->layout;

        ob_start();
        include_once __DIR__ . "/views/layouts/" . $layoutName . ".php";
        $layout = ob_get_clean();

        ob_start();
        include_once __DIR__ . "/views/" . $viewName . ".php";
        $view = ob_get_clean();

        echo str_replace("{{yield}}", $view, $layout);
    }
}