<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 22.03.19
 * Time: 16:43
 */

namespace App\User;


use App\Core\AbstractController;
use App\Entry\EntryRepository;

class AdminController extends AbstractController
{
    public function __construct(EntryRepository $entryRepository, LoginService $loginService)
    {
        $this->entryRepository = $entryRepository;
        $this->loginService = $loginService;
    }

    public function showUserEntries()
    {
        $this->loginService->check();

        $entries = $this->entryRepository->findByAuthor($_SESSION['login']);

        $this->render("layout/header", ['navigation' => $this->loginService->getNavigation()]);
        $this->render("User/userEntries", [
            'entries' => $entries
        ]);
    }
}