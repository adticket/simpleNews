<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 10:32
 */

/*
 * Start of session
 */
session_start();

/*
 * Include Init.php
 *  - loads autoloader
 *  - creates instance of container
 *  - contains function against sql-injections
 */
require __DIR__ . '/../init.php';

/*
 * Sets path if set in server array
 *  - index if nothing is set yet
 */
$pathInfo = $_SERVER['PATH_INFO'] ?? '/index';

/*
 * Array with all possible routes
 *  - contains path associated with controller and method
 */
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
        'controller' => 'adminController',
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
    ],
    '/search' => [
        'controller' => 'entryController',
        'method' => 'search'
    ]
];

/*
 * If path exists:
 *  - get controller
 *  - call method
 * else:
 *  - route is set to index
 *
 */
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