<?php

namespace app;

class View
{
    private $data = [];
    private $layoutName;

    public function __construct($layoutName)
    {
        $this->layoutName = $layoutName;
    }

    public function render($viewName, $params = [])
    {
        $layout = $this->getContent("layouts/$this->layoutName");
        $view = $this->getContent($viewName, $params);

        return str_replace("{{yield}}", $view, $layout);
    }

    public function addData($values)
    {
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