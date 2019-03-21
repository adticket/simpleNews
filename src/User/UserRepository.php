<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 21.03.19
 * Time: 11:18
 */

namespace App\User;

use App\Core\AbstractRepository;
use PDO;

class UserRepository extends AbstractRepository
{
    public function getTableName()
    {
        return 'users';
    }

    public function getModelName()
    {
        return 'App\\User\\UserModel';
    }

    public function findByUsername($username)
    {
        $username = e($username);
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE (username = :username)");
        $stmt->execute([':username' => $username]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $user =  $stmt->fetch(PDO::FETCH_CLASS);

        return $user;
    }
}