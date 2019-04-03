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
    /*
     *  primary key user identification number
     */
    public $userID;

    /*
     *  username unique
     */
    public $username;

    /*
     *  password stored as hash
     */
    public $password;

    /*
     *  users firstname
     */
    public $firstname;

    /*
     *  users surname
     */
    public $surname;

    /*
     *  users email address
     */
    public $email;
}