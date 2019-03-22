<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 21.03.19
 * Time: 16:59
 */

namespace App\User;

use App\Core\AbstractController;
use http\Header;

class UserController extends AbstractController
{
    public  function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login()
    {
        $error = false;
        if(!empty($_POST['login']) && !empty($_POST['password']))
        {
            $login = e($_POST['login']);
            $password = e($_POST['password']);

            if($this->loginService->attempt($login, $password))
            {
                header("Location: dashboard");
                return;
            }
            else
            {
                $error = true;
            }

        }
        $this->render(
            'User/login', ['error' => $error]);
    }

    public function logout()
    {
        $this->loginService->logout();
        header("Location: login");
    }

    public function register()
    {
        if(!empty($_POST()))
        $this->render('User/register',[]);
    }

    public function dashboard()
    {
        $this->loginService->check();

        $this->render("User/dashboard", []);
    }
}