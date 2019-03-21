<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 10:00
 */

namespace App\Entry;

use App\Core\AbstractRepository;

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

    public function insertEntry($title, $content)
    {
        $content = e($content);
        $title = e($title);
        $datetime = new \DateTime();
        $datetime = $datetime->format('Y-m-d H:i:s');
        $author = "Automatisieren";

        $stmt = $this->pdo->prepare("INSERT INTO BlogEntries (blogtitle, blogcontent, dateofentry, author) VALUES (:bt, :bc, :doe, :a)");
        $stmt->execute(['bt' => $title, 'bc' => $content, 'doe' => $datetime, 'a' => $author]);
    }
}