<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 22.03.19
 * Time: 16:43
 */

namespace App\User;


use App\Core\AbstractController;
use App\Core\PaginationService;
use App\Entry\EntryController;
use App\Entry\EntryModel;
use App\Entry\EntryRepository;

class AdminController extends AbstractController
{
    public function __construct(EntryRepository $entryRepository, LoginService $loginService, PaginationService $paginationService)
    {
        $this->entryRepository = $entryRepository;
        $this->loginService = $loginService;
        $this->paginationService = $paginationService;
    }

    public function showUserEntries()
    {
        $this->loginService->check();

        if(isset($_POST['entrytitle']) && isset($_POST['blogcontent']))
        {
            $this->entryRepository->insertEntry($_POST['entrytitle'], $_POST['blogcontent'], $_SESSION['login']);
        }

        $pagination = $this->paginationService->getPagination($_SESSION['login']);

        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        if($pagination['numPages']>1)
        {
            $this->render("layout/pagination", [
                'numPages' => $pagination['numPages']
            ]);
        }
        $this->render("User/userEntries", [
            'entries' => $pagination['entries']
        ]);
        if($pagination['numPages']>1)
        {
            $this->render("layout/pagination", [
                'numPages' => $pagination['numPages']
            ]);
        }
    }

    public function editEntry()
    {
        $this->loginService->check();

        $error = null;

        $entry = new EntryModel();
        $entry->entryID = e($_GET['eid']);

        if($entry->entryID != null)
        {
            if (isset($_POST['update']) && !empty($_POST['blogcontent']) && !empty($_POST['blogtitle'])) {
                $entry->blogtitle = e($_POST['blogtitle']);
                $entry->blogcontent = e($_POST['blogcontent']);
                $this->entryRepository->updateEntry($entry);
            }
            if (isset($_POST['delete'])) {
                $this->entryRepository->deleteById($entry);
                header("Location: userEntries");
            }
        }
        else
        {
            $error = "Post nicht gefunden.";
        }

        $entry = $this->entryRepository->findByIdAndAuthor($entry->entryID, $_SESSION['login']);

        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render("User/editEntry", [
            'entry' => $entry,
            'error' => $error
        ]);
    }

    public function addEntry()
    {
        $this->loginService->check();

        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render("User/addEntry", [

        ]);
    }
}