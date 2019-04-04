<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 18.03.19
 * Time: 21:41
 */

namespace App\Core;

use ArrayAccess;

/*
 * abstract Model class
 * implementing arrayAccess for Model
 */
abstract class AbstractModel implements ArrayAccess
{
    public function offsetExists($offset) : bool
    {
        return isset($this->$offset);
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value) : void
    {
        $this->$offset = $value;
    }

    public function offsetUnset($offset) : void
    {
        unset($this->$offset);
    }
}