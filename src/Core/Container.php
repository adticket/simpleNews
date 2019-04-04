<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 18.03.19
 * Time: 21:28
 */

namespace App\Core;

use App\Entry\EntryController;
use App\Entry\EntryRepository;
use App\User\AdminController;
use App\User\LoginService;
use App\User\UserController;
use App\User\UserRepository;
use PDO;
use PDOException;


class Container
{
    /*
     * instances:   contains existing instances
     * recipe:  contains constructor dependencies for all classes
     *          and calls make-method
     */
    private $instances = [];
    private $recipe;

    /*
     * creates and object of every class by using make-method
     */
    public function __construct()
    {
        $this->recipe = [
            'pdo' => static function()
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
                    echo "Verbindung zur Datenbank fehlgeschlagen!<br />Bitte kontaktieren Sie mich!";
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
                return new EntryController($this->make('entryRepository'), $this->make('loginService'), $this->make('paginationService'));
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
            },
            'adminController' => function()
            {
                return new AdminController($this->make('entryRepository'), $this->make('loginService'), $this->make('paginationService'));
            },
            'paginationService' => function()
            {
                return new PaginationService($this->make('entryRepository'));
            }
        ];
    }

    /*
     * checks if instance($name) already exists in $instances[]
     *  - returns it if it exists
     *  - else creates it after recipe[]
     *  - only one object of each class will exist
     */
    public function make($name)
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