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

        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render("User/userEntries", [
            'entries' => $entries
        ]);
    }

    public function editEntry()
    {
        $this->loginService->check();

        $error = null;
        $id = $_GET['eid'];

        if($id != null)
        {
            if (isset($_POST['update'])) {
                $this->entryRepository->updateEntry($id, e($_POST['blogtitle']), e($_POST['blogcontent']));
            }
            if (isset($_POST['delete'])) {
                $this->entryRepository->deleteById($id);
                header("Location: userEntries");
            }
        }
        else
        {
            $error = "Post nicht gefunden.";
        }

        $entry = $this->entryRepository->findByIdAndAuthor($id, $_SESSION['login']);

        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render("User/editEntry", [
            'entry' => $entry,
            'error' => $error
        ]);
    }
}