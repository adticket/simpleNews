<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 10:00
 */

namespace App\Entry;

use App\Core\AbstractRepository;
use PDO;

class EntryRepository extends AbstractRepository
{
    /*
     * returns name of model for methods
     */
    public function getModelName()
    {
        return 'App\\Entry\\EntryModel';
    }

    /*
     * returns table name of db
     */
    public function getTableName()
    {
        return 'BlogEntries';
    }

    /*
     *  - escapes user input
     *  - create date and time of entry and assign format
     *  - prepares statement, binds param, and executes it
     */
    public function insertEntry($title, $content, $author)
    {
        $content = e($content);
        $title = e($title);
        $datetime = new \DateTime();
        $datetime = $datetime->format('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("
            INSERT INTO BlogEntries (blogtitle, blogcontent, dateofentry, author) 
            VALUES (:bt, :bc, :doe, :a)"
        );
        $stmt->bindParam(':bt', $title, PDO::PARAM_STR);
        $stmt->bindParam(':bc', $content, PDO::PARAM_STR);
        $stmt->bindParam(':doe', $datetime, PDO::PARAM_STR);
        $stmt->bindParam(':a', $author, PDO::PARAM_STR);
        $stmt->execute();
    }

    /*
     *  - retrieves one entry from db by its id
     */
    function findById($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE entryID = :eid");
        $stmt->bindParam(':eid', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $entry = $stmt->fetch();

        return $entry;
    }

    /*
     *  - retrieve entry by its id and author
     *  - necessary for editing entries
     */
    function findByIdAndAuthor($id, $author)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE entryID = :eid AND author = :author");
        $stmt->bindParam(':eid', $id, PDO::PARAM_INT);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $entry = $stmt->fetch(8);

        return $entry;
    }

    /*
     *  - delete entry from db
     */
    function deleteById(EntryModel $entry)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("DELETE FROM {$table} WHERE entryID = :eid");
        $stmt->bindParam(':eid', $entry->entryID, PDO::PARAM_INT);
        $stmt->execute();
    }

    /*
     *
     */
    function updateEntry(EntryModel $entry)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("
            UPDATE {$table} 
            SET blogtitle = :bt, blogcontent = :bc 
            WHERE entryID = :eid"
        );
        $stmt->bindParam(':bt', $entry->blogtitle, PDO::PARAM_STR);
        $stmt->bindParam(':bc', $entry->blogcontent, PDO::PARAM_STR);
        $stmt->bindParam(':eid', $entry->entryID, PDO::PARAM_INT);
        $stmt->execute();
    }

    /*
     *  - get amount of entries by author
     *  - default parameter returns number of all entries
     */
    public function getEntryAmount($author="")
    {
        if(empty($author))
        {
            $stmt = $this->pdo->prepare("SELECT * FROM BlogEntries");
        }
        else
        {
            $stmt = $this->pdo->prepare("SELECT * FROM BlogEntries WHERE author = :author");
            $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->rowCount();
    }

    /*
     *  - parameter: current page, entries per page, author (default empty)
     *  -
     */
    public function getEntriesOfPage($page, $entriesPerPage, $author="")
    {
        /*
         * if page empty set page 1
         */
        if(empty($page))
        {
            $page=1;
        }

        /*
         * calculate offset for entries to retrieve
         */
        $offset = ($page-1)*$entriesPerPage;

        /*
         * get model and table for entries
         */
        $model = $this->getModelName();
        $table = $this->getTableName();

        //  Old query
        /*
         *  - if author empty return entries of all authors
         *
        if(empty($author))
        {
            $stmt = $this->pdo->prepare("
                SELECT * 
                FROM {$table} 
                ORDER BY dateofentry DESC 
                LIMIT :firstEntry,:entriesPerPage
            ");
        }
        else
        {
            $stmt = $this->pdo->prepare("
                                          SELECT * 
                                          FROM {$table} 
                                          WHERE author = :author 
                                          ORDER BY dateofentry DESC 
                                          LIMIT :firstEntry,:entriesPerPage
            ");
            $stmt->bindParam(':author', $author, PDO::PARAM_STR_NATL);

        }*/

        /*
         *  New query -> less code
         */
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM {$table}
            WHERE author
            LIKE :author
            ORDER BY dateofentry DESC 
            LIMIT :firstEntry, :entriesPerPage
        ");

        if(empty($author))
        {
            $author = "%";
        }

        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':firstEntry', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':entriesPerPage', $entriesPerPage, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, $model);
    }

    /*
     *  - returns array with all authors
     */
    public function getAuthors()
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT author 
            FROM {$table}
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}