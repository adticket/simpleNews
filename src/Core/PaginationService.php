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
     *  get entries of current page out of all arrays
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

    /*
     *  get all links of pagination
     *  - needs output by foreach
     */
    public function getPaginationBar($numberOfEntries) : array
    {
        $links = [];
        $numberOfPages = 1;
        $currentPage = (int)($_GET['page'] ?? '1');

        if ($numberOfEntries > $this->entriesPerPage) {
            $numberOfPages = (int)($numberOfEntries / $this->entriesPerPage);
            if (($numberOfEntries % $this->entriesPerPage) > 0) {
                $numberOfPages++;
            }
        }

        if($numberOfPages <= 5 && $numberOfPages > 1)
        {
            for($x = 1; $x <= $numberOfPages; $x++)
            {
                $links[] = $this->getLinkWithParams($x, $x);
            }
        }
        elseif($numberOfPages > 5)
        {
            /*
             *  go to first page link
             */
            $links[] = $this->getLinkWithParams(1, '&laquo;' );

            /*
             *  get links around current page
             */
            if ($currentPage <= 3)
            {
                for ($x = 1; $x <= 5; $x++)
                {
                    $links[] = $this->getLinkWithParams($x, $x);
                }
            }
            elseif ($currentPage >= $numberOfPages-2)
            {
                for ($x = ($numberOfPages-4); $x <= $numberOfPages; $x++)
                {
                    $links[] = $this->getLinkWithParams($x, $x);
                }
            }
            else
            {
                for ($x = $currentPage-2; $x <= $currentPage+2; $x++)
                {
                    $links[] = $this->getLinkWithParams($x, $x);
                }
            }

            /*
             *  go to last page link
             */
            $links[] = $this->getLinkWithParams($numberOfPages, '&raquo;');
        }
        return $links;
    }

    /*
     *  small method that creates links for pagination
     */
    private function getLinkWithParams($page, $linkString) : string
    {
        $currentPage = (int)($_GET['page'] ?? '1');
        $first = true;
        $link = ['<li class="page-item'];

        if($page === $currentPage && $page === $linkString)
        {
            $link[] = ' active">';
        }
        else
        {
            $link[] = '">';
        }

        $link[] = '<a class="page-link" href="?';

        if(isset($_GET['page']))
        {
            foreach($_GET as $key => $value)
            {
                if(!$first)
                {
                    $link[] = '&';
                }
                else
                {
                    $first = false;
                }
                if($key === 'page')
                {
                    $value=$page;
                }
                $link[] = $key . '=' . $value;
            }
        }
        else
        {
            foreach($_GET as $key => $value)
            {
                if(!$first)
                {
                    $link[] = '&';
                }
                else
                {
                    $first = false;
                }
                $link[] = $key . '=' . $value;
            }
            $link[] = '&page=' . $page;
        }

        $link[] = '">' . $linkString . '</a></li>';

        return implode('', $link);
    }
}