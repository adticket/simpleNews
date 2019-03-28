<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 27.03.19
 * Time: 09:26
 */

namespace App\Core;

use App\Entry\EntryRepository;

class PaginationService
{
    public function __construct(EntryRepository $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    public $entriesPerPage = 8;

    public function getPagination($author="")
    {
        $pagination = [
            'numPages' => null,
            'currentPage' => null,
            'entries' => null
        ];

        $numEntries = $this->entryRepository->getEntryAmount($author);

        if($numEntries > ($this->entriesPerPage))
        {
            $pagination['numPages'] = $numEntries/$this->entriesPerPage;
            if(($numEntries%$this->entriesPerPage)>0)
            {
                $pagination['numPages']++;
            }
        }

        if(empty($_GET['page']))
        {
            $pagination['currentPage'] = 1;
        }
        else
        {
            $pagination['currentPage'] = $_GET['page'];
        }

        $pagination['entries'] = $this->entryRepository->getEntriesOfPage(
            $pagination['currentPage'],
            $this->entriesPerPage,
            $author
        );

        return $pagination;
    }
}