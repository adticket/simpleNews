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
    public  function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /*
     *  - escaping login input
     *  - try to login
     *  - if it fails return error
     *  - render login page view
     */
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

        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render(
            'User/login', [
                'error' => $error
        ]);
    }

    /*
     *  - calls loginService to logout
     *  - redirects to login page view
     */
    public function logout()
    {
        $this->loginService->logout();
        header("Location: login");
    }

    /*
     *  - calls loginService register method
     *  - renders register page view
     */
    public function register()
    {
        $errors = $this->loginService->register();

        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render('User/register',[
            'errors' => $errors
        ]);
    }
}