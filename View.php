<?php

namespace app;

class View
{
    private $data = [];
    private $viewName;
    private $layoutName;

    public function __construct($viewName, $layoutName)
    {
        $this->viewName = $viewName;
        $this->layoutName = $layoutName;
    }

    public function render($params = [])
    {
        $layout = $this->getContent("layouts/$this->layoutName");
        $view = $this->getContent($this->viewName, $params);

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
