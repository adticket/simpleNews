<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 10:32
 */

session_start();

require __DIR__ . "/../init.php";

if(isset($_SERVER['PATH_INFO']))
{
    $pathInfo = $_SERVER['PATH_INFO'];
}
else
{
    $pathInfo = "/index";
}

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
    ],
    '/login' => [
        'controller' => 'userController',
        'method' => 'login'
    ],
    '/register' => [
        'controller' => 'userController',
        'method' => 'register'
    ],
    '/dashboard' => [
        'controller' => 'userController',
        'method' => 'dashboard'
    ],
    '/logout' => [
        'controller' => 'userController',
        'method' => 'logout'
    ],
    '/userEntries' => [
        'controller' => 'adminController',
        'method' => 'showUserEntries'
    ],
    '/editEntry' => [
        'controller' => 'adminController',
        'method' => 'editEntry'
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