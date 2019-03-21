<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 21.03.19
 * Time: 16:59
 */

namespace App\User;

use App\Core\AbstractController;

class UserController extends AbstractController
{
    public  function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login()
    {
        $this->render('User/login', []);
    }

    public function register()
    {
        $this->render('User/register',[]);
    }
}