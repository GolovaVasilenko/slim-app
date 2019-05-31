<?php


namespace App\Models;


class Rubric
{
    const TABLE = 'rubrics';

    static $db = null;

    public function getParentName()
    {
        $sql = "SELECT title FROM " . self::TABLE . " WHERE id=:id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['id' => $this->parent]);
        return $stmt->fetch()['title'];
    }
}