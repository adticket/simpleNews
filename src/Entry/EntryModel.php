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
    /*
     * id of entry - primary key
     */
    public $entryID;

    /*
     * title of entry (headline)
     */
    public $blogtitle;

    /*
     * content of entry
     */
    public $blogcontent;

    /*
     * date and time of entry creation
     */
    public $dateofentry;

    /*
     * creator of entry
     */
    public $author;

    /*
     * short version of content
     */
    public $shortContent;

    /*
     * length of short version
     */
    private $maxLength = 80;

    /*
     * create short content on creation if content exceeds max length of short content
     */
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