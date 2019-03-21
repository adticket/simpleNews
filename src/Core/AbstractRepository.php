<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 09:43
 */

namespace App\Core;

use PDO;

abstract class AbstractRepository
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    abstract function getTableName();
    abstract function getModelName();

    function all()
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->query("SELECT * FROM {$table}");
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $entries;
    }

    function allSortedByDate()
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->query("SELECT * FROM {$table} ORDER BY dateofentry DESC");
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $entries;
    }

    function find($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE entryID = :eid");
        $stmt->execute(['eid' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $entry = $stmt->fetch(8);

        return $entry;
    }
}