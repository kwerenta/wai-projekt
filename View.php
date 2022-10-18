<?php

namespace app;

class View
{
    public function render($viewName)
    {
        $layoutName = Application::$app->controller->layout;

        $layout = $this->getContent("layouts/$layoutName");
        $view = $this->getContent($viewName);

        echo str_replace("{{yield}}", $view, $layout);
    }

    private function getContent($path)
    {
        ob_start();
        include_once __DIR__ . "/views/" . $path . ".php";
        return ob_get_clean();
    }
}