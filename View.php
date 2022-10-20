<?php

namespace app;

class View
{
    public function render($viewName, $params = [])
    {
        $layoutName = Application::$app->controller->layout;

        $layout = $this->getContent("layouts/$layoutName");
        $view = $this->getContent($viewName, $params);

        echo str_replace("{{yield}}", $view, $layout);
    }

    private function getContent($path, $params = [])
    {
        ob_start();
        extract($params, EXTR_SKIP);
        include_once __DIR__ . "/views/" . $path . ".php";
        return ob_get_clean();
    }
}