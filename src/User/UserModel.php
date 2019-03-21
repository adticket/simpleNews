<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 20.03.19
 * Time: 17:36
 */

namespace App\User;

use App\Core\AbstractModel;

class UserModel extends AbstractModel
{
    public $userID;
    public $username;
    public $password;
    public $firstname;
    public $surname;
    public $email;
}