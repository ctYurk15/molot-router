<?php

namespace MolotRouter;

class URL
{
    private $uri = "";

    public function __construct($uri = null)
    {
        $this->uri = $uri;
    }

    public function getURI()
    {
        return $this->uri;
    }

    public function parseURI($uri = null)
    {
        $uri = strtok($uri == null ? $this->uri : $uri, '&'); //getting rid of url params
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

    public function matchPattern($pattern)
    {
        $parsed_uri = $this->parseURI();
        $parsed_pattern = $this->parseURI($pattern);

        if(count($parsed_uri) != count($parsed_pattern))
        {
            return false;
        }

        foreach($parsed_pattern as $index => $pattern_slug)
        {
            //if current slug is variable, we shouldn`t check it
            if(!(preg_match('/(?=^{)/', $pattern_slug) && preg_match('/(?=}$)/', $pattern_slug)))
            {
                if($pattern_slug != $parsed_uri[$index])
                {
                    return false;
                }
            }
        }

        return true;
    }
}