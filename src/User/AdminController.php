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
use App\Entry\EntryModel;
use App\Entry\EntryRepository;

class AdminController extends AbstractController
{
    /*
     *  -
     */
    public function __construct(EntryRepository $entryRepository, LoginService $loginService, PaginationService $paginationService)
    {
        $this->entryRepository = $entryRepository;
        $this->loginService = $loginService;
        $this->paginationService = $paginationService;
    }

    /*
     *  - checks if logged in
     *  - inserts entry if submitted by post
     *  - renders dashboard page with all user entries
     */
    public function showUserEntries() : void
    {
        /*
         * checks if user is logged in else redirect him to login page
         */
        $this->loginService->check();

        /*
         * checks if content was submitted
         */
        if(isset($_POST['entrytitle'], $_POST['blogcontent']))
        {
            $this->entryRepository->insertEntry($_POST['entrytitle'], $_POST['blogcontent'], $_SESSION['login']);
        }

        /*
         * get all entries
         */
        $allEntries = $this->entryRepository->getAllEntriesOfAuthor($_SESSION['login']);

        /*
         *  get currently needed entries
         */
        $currentEntries = $this->paginationService->getCurrentEntries($allEntries);

        /*
         *  get all elements for pagination
         */
        $paginationElements = $this->paginationService->getPaginationBar(count($allEntries));

        /*
         *  render navigation, pagination and entries
         */
        $this->render('layout/header', [
            'navigation' => $this->loginService->getNavigation()
        ]);

        $this->render('layout/pagination', [
            'paginationElements' => $paginationElements
        ]);

        $this->render('User/userEntries', [
            'entries' => $currentEntries
        ]);

        $this->render('layout/pagination', [
            'paginationElements' => $paginationElements
        ]);
    }

    /*
     *  - checks if logged in
     *  - checks if entry got updated by post
     *  - retrieves entry by id
     *  - renders page with form
     */
    public function editEntry() : void
    {
        $this->loginService->check();

        $error = null;

        $entry = new EntryModel();
        $entry->entryID = e($_GET['eid']);

        if($entry->entryID !== null)
        {
            if (isset($_POST['update']))
            {
                $content = trim($_POST['blogcontent']);
                $title = trim($_POST['blogtitle']);

                if(!empty($content) && !empty($title))
                {
                    $entry->blogtitle = e($_POST['blogtitle']);
                    $entry->blogcontent = e($_POST['blogcontent']);
                    $this->entryRepository->updateEntry($entry);
                }
                else
                {
                    $error = 'Der Eintrag darf nicht leer sein.';
                }

            }
            if (isset($_POST['delete'])) {
                $this->entryRepository->deleteById($entry);
                header('Location: userEntries');
            }
        }
        else
        {
            $error = 'Post nicht gefunden.';
        }

        $entry = $this->entryRepository->findByIdAndAuthor($entry->entryID, $_SESSION['login']);

        $this->render('layout/header', [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render('User/editEntry', [
            'entry' => $entry,
            'error' => $error
        ]);
    }

    /*
     *  - checks if logged in
     *  - renders form to create new entry
     */
    public function addEntry() : void
    {
        $this->loginService->check();

        $this->render('layout/header', [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render('User/addEntry', [
        ]);
    }
}