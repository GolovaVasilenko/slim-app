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

    public function getPosts()
    {
        $sql = "SELECT p.id, p.title, p.slug, p.body, p.created_at FROM posts p
                JOIN post_rubric pr ON pr.post_id = p.id 
                JOIN rubrics r ON pr.rubric_id = r.id WHERE pr.rubric_id=:id";
        $stmt = self::$db->prepare($sql);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute(['id' => $this->id]);
        return $stmt->fetch();
    }
}