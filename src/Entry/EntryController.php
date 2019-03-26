<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 10:46
 */

namespace App\Entry;

use App\Core\AbstractController;
use App\User\LoginService;

class EntryController extends AbstractController
{
    public function __construct(EntryRepository $entryRepository, LoginService $loginService)
    {
        $this->entryRepository = $entryRepository;
        $this->loginService = $loginService;
    }

    public function index()
    {
        if(isset($_POST['entrytitle']) && isset($_POST['blogcontent']))
        {
            $this->entryRepository->insertEntry($_POST['entrytitle'], $_POST['blogcontent'], $_SESSION['login']);
        }

        $limitPerPage = 10;
        $entries = $this->entryRepository->allSortedByDate();
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
        $this->render("Entries/index", [
            'entries' => $entries
        ]);
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
        $this->render("Entries/addEntry", [

        ]);
    }
}