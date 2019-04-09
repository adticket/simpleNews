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
    public $entriesPerPage = 4;

    /*
     * parameter: author - by default empty
     * returns: array[] containing number of pages, current page, and entries[]
     */
    public function getPagination($string) : array
    {
        /*
         * array gets filled with standard values
         */
        $pagination = [
            'numPages' => 1,
            'currentPage' => 1,
            'entries' => null
        ];

        if(isset($_GET['author']) || (empty($_GET['author']) && empty($_GET['search'])))
        {
            $author = $string;
            /*
             * get amount of entries by author
             *  - if author empty returns all
             */
            $numEntries = $this->entryRepository->getEntryAmount($author);

            /*
             * calculate number of pages
             */
            if ($numEntries > $this->entriesPerPage) {
                $pagination['numPages'] = (int)($numEntries / $this->entriesPerPage);
                if (($numEntries % $this->entriesPerPage) > 0) {
                    $pagination['numPages']++;
                }
            }

            /*
             * get current page by url
             *  - if not set, page 1 is set
             */
            if (empty($_GET['page'])) {
                $pagination['currentPage'] = 1;
            } else {
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
        }
        else
        {
            $pagination['entries'] = $this->entryRepository->searchEntries($string);
        }

        return $pagination;
    }

    /*
     *  get pagination bar with all elements
     */
    public function getPaginationElements($numPages) : array
    {
        $links = [];

        /*
         *  if less than 5 pages, dont show arrow to first and last page;
         */
        if($numPages<=5) {
            for ($x = 1; $x <= $numPages; $x++) {
                $link = [];

                $link[] = '<li class="page-item';

                if ((isset($_GET['page']) && $x === (int)$_GET['page']) || (!isset($_GET['page']) && $x === 1)) {
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

                $links[] = implode('', $link);
            }
            return $links;
        }
        /*
         *  else show scaling pagination
         */
        else
        {
            if(isset($_GET['author']))
            {
                $links[] = '<a class="page-link" href="?author=' . $_GET['author'] . '&page=1">&laquo;</a>';
            }
            else
            {
                $links[] = '<a class="page-link" href="?page=1">&laquo;</a>';
            }


            if (!isset($_GET['page']) || $_GET['page'] <= 3) {
                for ($x = 1; $x <= 5; $x++) {
                    $link = [];

                    $link[] = '<li class="page-item';

                    if ((isset($_GET['page']) && $x === (int)$_GET['page']) || (!isset($_GET['page']) && $x === 1)) {
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

                    $links[] = implode('', $link);
                }
            }

            elseif ($_GET['page'] >= $numPages - 2) {
                for ($x = $numPages - 4; $x <= $numPages; $x++) {
                    $link = [];

                    $link[] = '<li class="page-item';

                    if ((isset($_GET['page']) && $x === (int)$_GET['page']) || (!isset($_GET['page']) && $x === 1)) {
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

                    $links[] = implode('', $link);
                }
            }

            else
            {
                for ($x = $_GET['page']-2; $x <= $_GET['page']+2; $x++) {
                    $link = [];

                    $link[] = '<li class="page-item';

                    if ((isset($_GET['page']) && $x === (int)$_GET['page']) || (!isset($_GET['page']) && $x === 1)) {
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

                    $links[] = implode('', $link);
                }
            }

            if(isset($_GET['author']))
            {
                $links[] = '<a class="page-link" href="?author=' . $_GET['author'] . '&page=' . $numPages . '">&raquo;</a>';
            }
            else
            {
                $links[] = '<a class="page-link" href="?page=' . $numPages . '">&raquo;</a>';
            }
        }
        return $links;
    }

    /*
     *  trying to clean up
     */
    public function getCurrentEntries($entries) : array
    {
        if(isset($_GET['page']))
        {
            $currentPage = e($_GET['page']);
        }
        else
        {
            $currentPage = 1;
        }

        return array_slice($entries, ($currentPage-1)*$this->entriesPerPage, $this->entriesPerPage);
    }
}