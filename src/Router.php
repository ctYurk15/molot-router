<?php

namespace MolotRouter;

use MolotRouter\URL;
use MolotRouter\Route;

class Router
{
    private $routes;
    private $not_found_route;

    public function __construct(array $routes = null, $not_found_route = null)
    {
       //converting array routes to Routes::class
        if($routes != null)
        {
            foreach($routes as $route)
            {
                if(is_array($route))
                {
                    $route = new Route(...array_values($route));
                }
                $this->routes[] = $route;
            }
        }

        if($not_found_route != null)
        {
            $this->not_found_route = is_array($not_found_route) ? new Route(...$not_found_route) : $not_found_route;
        } 
    }

    public function getRoutemap()
    {
        $result = [];

        foreach($this->routes as $route)
        {
            $result[] = $route->getMap();
        }

        return $result;
    }

    public function getRoute(URL $url, string $method)
    {
        //checking each route if pattern & method fits
        foreach($this->routes as $route)
        {
            $match_result = $url->matchPattern($route->pattern);

            if($match_result['result'] && $route->method == $method)
            {
                $route->values = $match_result['values'];
                return $route;
            }
        }

        //returning predefined `404` action
        return $this->not_found_route;
    }
}