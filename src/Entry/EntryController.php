<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 10:46
 */

namespace App\Entry;

use App\Core\AbstractController;
use App\Core\PaginationService;
use App\User\LoginService;

class EntryController extends AbstractController
{
    public function __construct(EntryRepository $entryRepository, LoginService $loginService, PaginationService $paginationService)
    {
        $this->entryRepository = $entryRepository;
        $this->loginService = $loginService;
        $this->paginationService = $paginationService;
    }

    public function index()
    {
        if(isset($_GET['author']))
        {
            $author = $_GET['author'];
        }
        else
        {
            $author = "";
        }

        $pagination = $this->paginationService->getPagination($author);
        $authors = $this->entryRepository->getAuthors();

        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        if($pagination['numPages']>1)
        {
            $this->render("layout/pagination", [
                'numPages' => $pagination['numPages']
            ]);
        }
        $this->render("layout/authorSearch",[
            'authors' => $authors
        ]);
        $this->render("Entries/index", [
            'entries' => $pagination['entries']
        ]);
        if($pagination['numPages']>1)
        {
            $this->render("layout/pagination", [
                'numPages' => $pagination['numPages']
            ]);
        }
    }

    public function singleEntry()
    {
        $id = $_GET['eid'];
        $entry = $this->entryRepository->findById($id);
        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render("Entries/singleEntry", [
            'entry' => $entry
        ]);
    }

    public function addEntry()
    {
        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render("User/addEntry", [

        ]);
    }
}