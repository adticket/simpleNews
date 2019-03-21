<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 18.03.19
 * Time: 21:36
 */

namespace App\Entry;

use App\Core\AbstractModel;

class EntryModel extends AbstractModel
{
    public $entryID;
    public $blogtitle;
    public $blogcontent;
    public $dateofentry;
    public $author;
    public $shortContent;
    private $maxLength = 80;

    function __construct()
    {
        if(strlen($this->blogcontent) < $this->maxLength)
        {
            $this->shortContent = $this->blogcontent;
        }
        else
        {
            $this->shortContent = substr($this->blogcontent, 0, $this->maxLength) . '...';
        }
    }
}