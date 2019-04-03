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
    /*
     * creates access to entry repository
     */
    public function __construct(EntryRepository $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    /*
     * entries per page
     */
    public $entriesPerPage = 8;

    /*
     * parameter: author - by default empty
     * returns: array[] containing number of pages, current page, and entries[]
     */
    public function getPagination($author="")
    {
        /*
         * array gets filled with standard values
         */
        $pagination = [
            'numPages' => 1,
            'currentPage' => 1,
            'entries' => null
        ];

        /*
         * get amount of entries by author
         *  - if author empty returns all
         */
        $numEntries = $this->entryRepository->getEntryAmount($author);

        /*
         * calculate number of pages
         */
        if($numEntries > ($this->entriesPerPage))
        {
            $pagination['numPages'] = $numEntries/$this->entriesPerPage;
            if(($numEntries % $this->entriesPerPage) > 0)
            {
                $pagination['numPages']++;
            }
        }

        /*
         * get current page by url
         *  - if not set, page 1 is set
         */
        if(empty($_GET['page']))
        {
            $pagination['currentPage'] = 1;
        }
        else
        {
            $pagination['currentPage'] = $_GET['page'];
        }

        /*
         * retrieve all entries of current page
         */
        $pagination['entries'] = $this->entryRepository->getEntriesOfPage(
            $pagination['currentPage'],
            $this->entriesPerPage,
            $author
        );

        return $pagination;
    }

    public function getPaginationElements($numPages)
    {
        $links = [];

        for($x=1; $x<=$numPages; $x++)
        {
            $link = [];

            $link[] = '<li class="page-item';

            if (isset($_GET['page']) && $x == $_GET['page'] || (!isset($_GET['page']) && $x == 1)) {
                $link[] = ' active">';
            } else {
                $link[] = '">';
            }

            if (isset($_GET['author'])) {
                $link[] = '<a class="page-link" href="?author=' . $_GET['author'] . '&page=' . $x . '">' . $x . '</a>';
            } else {
                $link[] = '<a class="page-link" href="?page=' . $x . '">' . $x . '</a>';
            }

            $link[] = '</li>';

            $links[] = implode("", $link);
        }
        return $links;
    }
}