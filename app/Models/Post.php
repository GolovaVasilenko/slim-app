<?php


namespace app\Models;


class Post
{
    const TABLE = 'posts';

    static $db = null;

    public function getRubricsId()
    {
        $sql = "SELECT rubric_id FROM post_rubric WHERE post_id=:post_id";
        $stmt = self::$db->prepare($sql);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute(['post_id' => $this->id]);
        $result = [];
        $tmp = $stmt->fetchAll();
        foreach($tmp as $value) {
            $result[] = $value['rubric_id'];
        }
        return $result;
    }

    public function getImage()
    {
        $sql = "SELECT m.id, m.url, m.title, m.alt, m.description FROM media AS m 
                JOIN node_media AS nm ON nm.media_id=m.id 
                JOIN posts AS p ON nm.node_id=p.id 
                WHERE p.id=:id";
        $stmt = self::$db->prepare($sql);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute(['id' => $this->id]);
        return $stmt->fetch();
    }
}