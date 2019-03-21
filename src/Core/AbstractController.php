<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 11:11
 */

namespace App\Core;

abstract class AbstractController
{
    protected function render($view, $params)
    {
        extract($params);

        include __DIR__ . "/../../views/{$view}.php";
    }
}