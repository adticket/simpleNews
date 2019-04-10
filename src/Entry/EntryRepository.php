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
    public function getModelName() : string
    {
        return 'App\\Entry\\EntryModel';
    }

    /*
     * returns table name of db
     */
    public function getTableName() : string
    {
        return 'BlogEntries';
    }

    /*
     *  - escapes user input
     *  - create date and time of entry and assign format
     *  - prepares statement, binds param, and executes it
     */
    public function insertEntry($title, $content, $author) : void
    {
        $table = $this->getTableName();
        $content = e($content);
        $title = e($title);
        $datetime = new \DateTime();
        $datetime = $datetime->format('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("
            INSERT INTO {$table} (blogtitle, blogcontent, dateofentry, author) 
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
    public function findById($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE entryID = :eid");
        $stmt->bindParam(':eid', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $stmt->execute();

        return $stmt->fetch();
    }

    /*
     *  - retrieve entry by its id and author
     *  - necessary for editing entries
     */
    public function findByIdAndAuthor($id, $author)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE entryID = :eid AND author = :author");
        $stmt->bindParam(':eid', $id, PDO::PARAM_INT);
        $stmt->bindParam(':author', $author);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $stmt->execute();

        return $stmt->fetch();
    }

    /*
     *  - delete entry from db
     */
    public function deleteById(EntryModel $entry) : void
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("DELETE FROM {$table} WHERE entryID = :eid");
        $stmt->bindParam(':eid', $entry->entryID, PDO::PARAM_INT);
        $stmt->execute();
    }

    /*
     *
     */
    public function updateEntry(EntryModel $entry) : void
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("
            UPDATE {$table} 
            SET blogtitle = :bt, blogcontent = :bc 
            WHERE entryID = :eid"
        );
        $stmt->bindParam(':bt', $entry->blogtitle);
        $stmt->bindParam(':bc', $entry->blogcontent);
        $stmt->bindParam(':eid', $entry->entryID, PDO::PARAM_INT);
        $stmt->execute();
    }


    /*
     *  - returns array with all authors
     */
    public function getAuthors() : array
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT author 
            FROM {$table}
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /*
     *  - return all entries that contain the string parameter in title or content
     */
    public function searchEntries($string) : array
    {
        $model = $this->getModelName();
        $table = $this->getTableName();
        $query = "%" . $string . "%";

        $stmt = $this->pdo->prepare("
            SELECT *
            FROM {$table}
            WHERE blogcontent
            LIKE :searchQuery
            UNION
            SELECT * 
            FROM {$table}
            WHERE blogtitle
            LIKE :searchQuery
            ORDER BY dateofentry DESC 
        ");

        $stmt->bindParam(':searchQuery', $query);

        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /*
     *  - return all entries of one author
     */
    public function getAllEntriesOfAuthor($author) : array
    {
        $model = $this->getModelName();
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("
            SELECT * 
            FROM {$table}
            WHERE author 
            LIKE :author
            ORDER BY dateofentry DESC 
        ");
        $stmt->bindParam(':author', $author);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}