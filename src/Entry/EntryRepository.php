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

    function findByAuthor($author)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE author = :author ORDER BY dateofentry DESC ");
        $stmt->execute(['author' => $author]);
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $entries;
    }
}