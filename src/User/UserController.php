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
    public  function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login()
    {
        $error = false;
        if(!empty($_POST['login']) && !empty($_POST['password']))
        {
            $login = e($_POST['login']);

            if(filter_var($login, FILTER_VALIDATE_EMAIL))
            {
                $user = $this->userRepository->findByEmail($login);
                if(!empty($user))
                {
                    if (password_verify($_POST['password'], $user['password']))
                    {
                        $_SESSION['login'] = $user['username'];
                        session_regenerate_id(true);
                        header("Location: dashboard");
                        return;
                    }
                    else
                    {
                        $error = true;
                    }
                }
                else
                {
                    $error = true;
                }
            }
            else
            {
                $user = $this->userRepository->findByUsername($login);
                if(!empty($user))
                {
                    if (password_verify($_POST['password'], $user['password']))
                    {
                        $_SESSION['login'] = $user['username'];
                        session_regenerate_id(true);
                        header("Location: dashboard");
                        return;
                    }
                    else
                    {
                        $error = true;
                    }
                }
                else
                {
                    $error = true;
                }
            }
        }
        $this->render(
            'User/login', ['error' => $error]);
    }

    public function logout()
    {
        unset($_SESSION['login']);
        session_regenerate_id(true);
        header("Location: login");
    }

    public function register()
    {
        $this->render('User/register',[]);
    }

    public function dashboard()
    {
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
        }
        else
        {
            echo "Niemand eingeloggt";
        }
    }
}