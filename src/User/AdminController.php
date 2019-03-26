<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 22.03.19
 * Time: 16:43
 */

namespace App\User;


use App\Core\AbstractController;
use App\Entry\EntryModel;
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

        $limitPerPage = 10;
        $entries = $this->entryRepository->findByAuthor($_SESSION['login']);
        $numPages = $this->entryRepository->calculatePagination($entries, $limitPerPage);
        $entries = $this->entryRepository->getPartOfArray($entries, $limitPerPage);

        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        if($numPages>0)
        {
            $this->render("layout/pagination", [
                'numPages' => $numPages
            ]);
        }
        $this->render("User/userEntries", [
            'entries' => $entries
        ]);
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
}