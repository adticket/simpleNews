<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 10:32
 */

require __DIR__ . "/../init.php";

$pathInfo = $_SERVER['PATH_INFO'];

$routes = [
    '/index' => [
        'controller' => 'entryController',
        'method' => 'index'
    ],
    '/entry' => [
        'controller' => 'entryController',
        'method' => 'singleEntry'
    ],
    '/addEntry' => [
        'controller' => 'entryController',
        'method' => 'addEntry'
    ]
];

if(isset($routes[$pathInfo]))
{
    $route = $routes[$pathInfo];
    $controller = $container->make($route['controller']);
    $method = $route['method'];
    $controller->$method();
}
else
{
    $route = $routes['/index'];
    $controller = $container->make($route['controller']);
    $method = $route['method'];
    $controller->$method();
}