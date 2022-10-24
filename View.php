<?php

namespace app;

class View
{
    private $data = [];

    public function render($viewName, $params = [])
    {
        $layoutName = Application::$app->controller->layout;

        $layout = $this->getContent("layouts/$layoutName");
        $view = $this->getContent($viewName, $params);

        return str_replace("{{yield}}", $view, $layout);
    }

    public function addData($values) {
        $this->data = array_merge($this->data, $values);
    }

    private function getContent($path, $params = [])
    {
        ob_start();
        extract($params, EXTR_SKIP);
        extract($this->data, EXTR_SKIP);
        include_once __DIR__ . "/views/" . $path . ".php";
        return ob_get_clean();
    }
}