<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 22.03.19
 * Time: 12:20
 */

namespace App\User;

use Exception;


class LoginService
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /*
     *  - checks if login is username or mail adress
     *  - tries to login
     *  - if successful sets login and regenerates session id
     *  - error displays error message on page
     */
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

    /*
     *  - unset login
     *  - regenerate session id
     */
    public function logout()
    {
        unset($_SESSION['login']);
        session_regenerate_id(true);
    }

    /*
     *  - checks if login is set
     *  - if not method dies redirecting to login page
     */
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

    /*
     *  - if received information by post escape and validate input
     *  - if validate input create user else return error messages
     */
    public function register()
    {
        if(!empty($_POST))
        {
            $errors=[];
            $firstname = e($_POST['firstname']);
            $surname = e($_POST['surname']);
            $username = e($_POST['username']);
            $email = e($_POST['email']);
            $password1 = e($_POST['password']);
            $password2 = e($_POST['password2']);
            $passwordhash = password_hash($password1, PASSWORD_DEFAULT);

            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $errors[] = "Ungültige E-Mail-Adresse";
            }
            if(!empty($this->userRepository->findByEmail($email)))
            {
                $errors[] = "E-Mail-Adresse bereits vorhanden";
            }

            if(!password_verify($password2, $passwordhash))
            {
                $errors[] = "Passwörter stimmen nicht überein";
            }

            if(!empty($this->userRepository->findByUsername($username)))
            {
                $errors[] = "Username bereits verwendet";
            }

            if(empty($errors)) {
                try {
                    $this->userRepository->addUser($username, $firstname, $surname, $passwordhash, $email);
                    return null;
                } catch (Exception $exception) {
                    $errors[] = "Account konnte nicht erstellt werden";
                }
            }

            return $errors;
        }
    }

    /*
     *  - returns navigation depending if logged in or not
     */
    public function getNavigation()
    {
        if(isset($_SESSION['login']))
        {
            return [
                'index' => 'Startseite',
                'dashboard' => 'Dashboard',
                'logout' => 'Logout'
                ];
        }
        else
        {
            return [
                'index' => 'Startseite',
                'login' => 'Login'
            ];
        }
    }
}