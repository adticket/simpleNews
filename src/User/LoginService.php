<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 22.03.19
 * Time: 12:20
 */

namespace App\User;


class LoginService
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function attempt($login, $password)
    {
        if(filter_var($login, FILTER_VALIDATE_EMAIL))
        {
            $user = $this->userRepository->findByEmail($login);
            if(!empty($user))
            {
                if (password_verify($password, $user['password']))
                {
                    $_SESSION['login'] = $user['username'];
                    session_regenerate_id(true);
                    header("Location: dashboard");
                    return true;
                }
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
                    return true;
                }
            }

        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['login']);
        session_regenerate_id(true);
    }

    public function check()
    {
        if(isset($_SESSION['login']))
        {
            return true;
        }
        else
        {
            header("Location: login");
            die;
        }
    }
}