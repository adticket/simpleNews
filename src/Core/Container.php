<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 18.03.19
 * Time: 21:28
 */

namespace App\Core;

use App\Entry\EntryController;
use App\User\LoginService;
use App\User\UserController;
use App\User\UserRepository;
use PDO;
use App\Entry\EntryRepository;
use PDOException;


class Container
{
    private $instances = [];
    private $recipe = [];

    function __construct()
    {
        $this->recipe = [
            'pdo' => function()
            {
                try
                {
                    $pdo = new PDO(
                        "mysql:host=localhost;dbname=mydb;charset=utf8",
                        "myblog",
                        "wxs0acpgOJHlk6ik");
                }
                catch(PDOException $e)
                {
                    echo "Verbindung zur Datenbank fehlgeschlagen";
                    die;
                }
                return $pdo;
            },
            'entryRepository' => function()
            {
                return new EntryRepository($this->make('pdo'));
            },
            'entryController' => function()
            {
                return new EntryController($this->make('entryRepository'), $this->make('loginService'));
            },
            'userRepository' => function()
            {
                return new UserRepository($this->make('pdo'));
            },
            'userController' => function()
            {
                return new UserController($this->make('loginService'));
            },
            'loginService' => function()
            {
                return new LoginService($this->make('userRepository'));
            }
        ];

    }

    function make($name)
    {
        if(!empty($this->instances[$name]))
        {
            return $this->instances[$name];
        }
        if(isset($this->recipe[$name]))
        {
            $this->instances[$name] = $this->recipe[$name]();
        }
        return $this->instances[$name];
    }
}