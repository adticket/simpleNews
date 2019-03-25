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

        $stmt = $this->pdo->prepare("INSERT INTO 
            BlogEntries (blogtitle, blogcontent, dateofentry, author) 
            VALUES (:bt, :bc, :doe, :a)"
        );
        $stmt->execute([
            'bt' => $title,
            'bc' => $content,
            'doe' => $datetime,
            'a' => $author
        ]);
    }

    function allSortedByDate()
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->query("SELECT * FROM {$table} ORDER BY dateofentry DESC");
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $entries;
    }

    function findById($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE entryID = :eid");
        $stmt->execute(['eid' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $entry = $stmt->fetch(8);

        return $entry;
    }

    function findByIdAndAuthor($id, $author)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE entryID = :eid AND author = :author");
        try
        {
            $stmt->execute([
                'eid' => $id,
                'author' => $author
            ]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
            $entry = $stmt->fetch(8);
        }
        catch (Exception $exception)
        {
            var_dump($exception);
        }
        return $entry;
    }

    function findByAuthor($author)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE author = :author ORDER BY dateofentry DESC ");
        $stmt->execute(['author' => $author]);
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $entries;
    }

    function deleteById(EntryModel $entry)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("DELETE FROM {$table} WHERE entryID = :eid");
        $stmt->execute(['eid' => $entry->entryID]);
    }

    function updateEntry(EntryModel $entry)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("UPDATE {$table} SET blogtitle = :bt, blogcontent = :bc WHERE entryID = :eid");
        $stmt->execute([
            'bt' => $entry->blogtitle,
            'bc' => $entry->blogcontent,
            'eid' => $entry->entryID
        ]);
    }
}