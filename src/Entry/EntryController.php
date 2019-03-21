<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 10:46
 */

namespace App\Entry;

use App\Core\AbstractController;

class EntryController extends AbstractController
{
    public function __construct(EntryRepository $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    public function index()
    {
        if(isset($_POST['entrytitle']) && isset($_POST['blogcontent']))
        {
            $this->entryRepository->insertEntry($_POST['entrytitle'], $_POST['blogcontent']);
        }

        $entries = $this->entryRepository->allSortedByDate();

        $this->render("Entries/index", ['entries' => $entries]);
    }

    public function singleEntry()
    {
        $id = $_GET['eid'];
        $entry = $this->entryRepository->find($id);
        $this->render("Entries/singleEntry", ['entry' => $entry]);
    }

    public function addEntry()
    {
        $this->render("Entries/addEntry", []);
    }
}