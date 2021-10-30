<?php

namespace MolotRouter;

class Route
{
    public $pattern;
    public $method;
    public $action;

    public $values = [];

    public function __construct(string $pattern = null, string $method = null, string $action = null)
    {
        $this->pattern = $pattern;
        $this->method = $method;
        $this->action = $action;
    }

    public function getMap()
    {
        return [
            'pattern' => $this->pattern,
            'method' => $this->method,
            'action' => $this->action
        ];
    }

    public function execute()
    {
        $parts = explode('@', $this->action);

        $class = $parts[0];
        $method = $parts[1];

        $controller = new $class();
        $controller->$method(...($this->values));
    }

}