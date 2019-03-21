<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 18.03.19
 * Time: 21:24
 */

require __DIR__ . "/autoload.php";

function e($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

$container = new App\Core\Container();
