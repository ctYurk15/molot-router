# MolotRouter

Simple router for php.

# Installation

To install this package you need to:
1. Install composer
2. Add line to your composer.json file in project folder:
```
"minimum-stability": "dev"
```
3. Go to your project folder with console
4. Write down next command:
```
composer require ctyurk15/molot-router
```

# Example:
```php
<?php

include "vendor/autoload.php";
use MolotRouter\Router as Router;
use MolotRouter\URL as URL;
use MolotRouter\Route as Route;

//creating routemap. here can be instances for Route class too 
$routes = [

    [
        'pattern' => '/',
        'method' => 'GET',
        'action' => 'Class1@home'
    ],
    [
        'pattern' => '/product/{id}',
        'method' => 'GET',
        'action' => 'Class1@product'
    ],
    [
        'pattern' => '/product',
        'method' => 'POST',
        'action' => 'Class1@add_product'
    ],
];

//some kind of controller
class Class1
{
    public function home()
    {
        echo 'home<hr>';
    }

    public function product($id)
    {
        echo 'Product '.$id.'<hr>';
    }

    public function not_found()
    {
        echo '404<hr>';
    }
}

//initializing current url
$url = new URL($_SERVER['REQUEST_URI']);

//initializing route
//Class1@not_found will be returned if router won`t find any routes
$router = new Router($routes, ['', '', 'Class1@not_found']);

//getting current route
$route = $router->getRoute($url, $_SERVER['REQUEST_METHOD']);

//executing his action
$route->execute();
```

# !!! IMPORTANT !!!
You should redirect all requests to file, that executes router. For example, .htaccess code:
```
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^.*$ /index.php [L,QSA]
```
