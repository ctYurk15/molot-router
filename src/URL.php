<?php

namespace MolotRouter;

class URL
{
    private $uri = "";

    public function __construct(string $uri = null)
    {
        $this->uri = $uri;
    }

    public function getURI()
    {
        return $this->uri;
    }

    public function parseURI(string $uri = null)
    {
        $request_uri = $uri == null ? $this->uri : $uri;
        $request_uri = str_replace('?', '&', $request_uri);
        $uri = strtok($request_uri, '&'); //getting rid of url params
        $result = explode('/', $uri);

        //deleting empty parts
        foreach($result as $index => $slug)
        {
            if($slug == '')
            {
                unset($result[$index]);
            }
        }

        //setting indexes back
        $result = array_values($result);

        return $result;
    }

    public function matchPattern(string $pattern)
    {
        $parsed_uri = $this->parseURI();
        $parsed_pattern = $this->parseURI($pattern);
        $arguments = [];

        if(count($parsed_uri) != count($parsed_pattern))
        {
            return ['result' => false];
        }

        foreach($parsed_pattern as $index => $pattern_slug)
        {
            //if current slug is variable, we shouldn`t check it
            if(!(preg_match('/(?=^{)/', $pattern_slug) && preg_match('/(?=}$)/', $pattern_slug)))
            {
                if($pattern_slug != $parsed_uri[$index])
                {
                    return ['result' => false];
                }
            }
            else
            {
                $arguments[] = $parsed_uri[$index];
            }
        }

        return ['result' => true, 'values' => $arguments];
    }
}