<?php


namespace app\Models;


class Post
{
    const TABLE = 'posts';

    static $db = null;

    public function getRubricId()
    {
        $sql = "SELECT rubric_id FROM post_rubric WHERE post_id=:post_id";
        $stmt = self::$db->prepare($sql);

        $stmt->execute(['post_id' => $this->id]);
        return $stmt->fetch();
    }
}