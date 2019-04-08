<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 09:43
 */

namespace App\Core;

use PDO;

/*
 * Abstract Class for repository
 *  - ensures that connection to database is available
 */
abstract class AbstractRepository
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    abstract public function getTableName();
    abstract public function getModelName();
}