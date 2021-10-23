<?php

namespace MolotRouter;

use MolotRouter\URL;

class Router
{
    private $routes;
    private $not_found_action;

    public function __construct(array $routes = null, string $not_found_action = null)
    {
        $this->routes = $routes;
        $this->not_found_action = $not_found_action;
    }

    public function getRoutemap()
    {
        return $this->routes;
    }

    public function getRouteAction(URL $url, string $method)
    {
        //checking each route if pattern & method fits
        foreach($this->routes as $route)
        {
            if($url->matchPattern($route['pattern']) && $route['method'] == $method)
            {
                return $route['action'];
            }
        }

        //returning predefined `404` action
        return $this->not_found_action;
    }
}