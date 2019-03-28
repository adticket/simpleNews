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
use Exception;

class EntryRepository extends AbstractRepository
{
    public function getModelName()
    {
        return 'App\\Entry\\EntryModel';
    }

    public function getTableName()
    {
        return 'BlogEntries';
    }

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

    function findById($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE entryID = :eid");
        $stmt->bindParam(':eid', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $entry = $stmt->fetch(8);

        return $entry;
    }

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

    function deleteById(EntryModel $entry)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("DELETE FROM {$table} WHERE entryID = :eid");
        $stmt->bindParam(':eid', $entry->entryID, PDO::PARAM_INT);
        $stmt->execute();
    }

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

    public function getEntryAmount($author="")
    {
        if(empty($author))
        {
            $stmt = $this->pdo->prepare("SELECT * FROM BlogEntries");
            $stmt->execute();
            return $stmt->rowCount();
        }
        else
        {
            $stmt = $this->pdo->prepare("SELECT * FROM BlogEntries WHERE author = :author");
            $stmt->bindParam(':author', $author, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
        }
    }

    public function getEntriesOfPage($page, $entriesPerPage, $author="")
    {
        if(empty($page))
        {
            $page=1;
        }
        $offset = ($page-1)*$entriesPerPage;
        $model = $this->getModelName();
        $table = $this->getTableName();


        if(empty($author))
        {
            $stmt = $this->pdo->prepare("
                                        SELECT * 
                                        FROM {$table} 
                                        ORDER BY dateofentry DESC 
                                        LIMIT :firstEntry,:entriesPerPage
            ");
            $stmt->bindParam(':firstEntry', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':entriesPerPage', $entriesPerPage, PDO::PARAM_INT);
            $stmt->execute();
            $entries = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
            return $entries;
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
            $stmt->bindParam(':firstEntry', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':entriesPerPage', $entriesPerPage, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, $this->getModelName());
        }
    }

    public function getAuthors()
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT author 
            FROM {$table}
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::PARAM_STR);
    }
}