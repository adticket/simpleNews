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

    /*
     *  - retrieve all necessary data
     *  - calls render function for pagination and entries and navigation
     */
    public function index() : void
    {
        /*
         *  find if filter is set
         */
        if(isset($_GET['author']))
        {
            $author = e($_GET['author']);
        }
        else
        {
            $author = '';
        }

        /*
         *  get pagination containing entries filtered by page and author
         */
        $pagination = $this->paginationService->getPagination($author);

        /*
         *  get all authors for filter
         */
        $authors = $this->entryRepository->getAuthors();

        /*
         *  get all elements for pagination
         */
        $paginationElements = $this->paginationService->getPaginationElements($pagination['numPages']);

        /*
         *  call render function for navigation bar
         */
        $this->render('layout/header', [
            'navigation' => $this->loginService->getNavigation()
        ]);

        /*
         *  call render function for pagination if there is more than one page
         */
        if($pagination['numPages']>1)
        {
            $this->render('layout/pagination', [
                'paginationElements' => $paginationElements
            ]);
        }

        /*
         *  render filter option
         */
        $this->render('layout/authorSearch',[
            'authors' => $authors
        ]);

        /*
         *  render entries
         */
        $this->render('Entries/index', [
            'entries' => $pagination['entries']
        ]);

        /*
         *  render pagination on bottom of site
         */
        if($pagination['numPages']>1)
        {
            $this->render('layout/pagination', [
                'paginationElements' => $paginationElements
            ]);
        }
    }

    /*
     *  - retrieve entry id from url
     *  - call render function with entry
     */
    public function singleEntry() : void
    {
        $id = $_GET['eid'];

        $entry = $this->entryRepository->findById($id);

        $this->render('layout/header', [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render('Entries/singleEntry', [
            'entry' => $entry
        ]);
    }

    public function search() : void
    {
        if(isset($_GET))
        {
            $searchQuery = e($_GET['search']);
        }
        else
        {
            $searchQuery='';
        }

        // Test
        $allEntries = $this->entryRepository->searchEntries($searchQuery);
        $currentEntries = $this->paginationService->getCurrentEntries($allEntries);


        /*
         *  get pagination containing entries filtered by page and author
         */
        $pagination = $this->paginationService->getPagination($searchQuery);


        /*
         *  get all elements for pagination
         */
        $paginationElements = $this->paginationService->getPaginationElements($pagination['numPages']);

        $this->render('layout/header', [
            'navigation' => $this->loginService->getNavigation()
        ]);

        /*
         *  call render function for pagination if there is more than one page
         */
        if($pagination['numPages']>1)
        {
            $this->render('layout/pagination', [
                'paginationElements' => $paginationElements
            ]);
        }

        $this->render('Entries/searchResults', [
            'searchQuery' => $searchQuery,
            'searchResults' => $pagination['entries']
        ]);
    }
}