<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 11:11
 */

namespace App\Core;

/*
 * abstract Controller class
 *  - provides render method
 */
abstract class AbstractController
{
    protected function render($view, $params) : void
    {
        extract($params, EXTR_SKIP);

        include __DIR__ . "/../../views/{$view}.php";
    }
}