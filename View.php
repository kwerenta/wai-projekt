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
        $layout = $this->getContent("layouts/$this->layoutName", false);
        $view = $this->getContent($this->viewName, true, $params);

        return str_replace("{{yield}}", $view, $layout);
    }

    public function addData($values)
    {
        $this->data = array_merge($this->data, $values);
    }

    public function setName($name)
    {
        $this->viewName = $name;
    }

    private function getContent($path, $isRequired, $params = [])
    {
        ob_start();
        extract($params, EXTR_SKIP);
        extract($this->data, EXTR_SKIP);
        $path = __DIR__ . "/views/" . $path . ".php";
        if ($isRequired)
            include_once $path;
        else
            require_once $path;
        return ob_get_clean();
    }
}
