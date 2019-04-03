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
    /*
     *  - returns table name in db
     */
    public function getTableName()
    {
        return 'users';
    }

    /*
     *  - return model to store data as
     */
    public function getModelName()
    {
        return 'App\\User\\UserModel';
    }

    /*
     *  - returns user object (found by username)
     */
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

    /*
     *  - returns user object (found by email)
     */
    public function findByEmail($email)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE (email = :email)");
        $stmt->execute([':email' => $email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $user =  $stmt->fetch(PDO::FETCH_CLASS);

        return $user;
    }

    /*
     *  - add user to db
     *  - prepare statement, bind parameter, execute statement
     */
    public function addUser($username, $firstname, $surname, $passwordhash, $email)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("
            INSERT INTO {$table} (username, password, firstname, surname, email)
            VALUES (:un, :pw, :fn, :sn, :email)");
        $stmt->bindParam(':un', $username, PDO::PARAM_STR);
        $stmt->bindParam(':pw', $passwordhash, PDO::PARAM_STR);
        $stmt->bindParam(':fn', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':sn', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();
    }
}