<?php

namespace App\Services;


use App\Models\Post;

class PostServiceManager extends AbstractServiceManager
{

    /**
     * @return mixed
     */
    public static function getTable()
    {
        return Post::TABLE;
    }

    /**
     * @return mixed
     */
    public static function getClass()
    {
        return Post::class;
    }

    /**
     * @param $rubric_id
     * @param $post_id
     * @return mixed
     */
    public function attachToCategory($rubric_id, $post_id)
    {
        $this->detachFromCategory($post_id);

        $sql = "INSERT INTO post_rubric (rubric_id, post_id) VALUES (:rubric_id, :post_id)";
        $stmt = $this->c->get('db')->prepare($sql);
        return $stmt->execute([ 'rubric_id' => $rubric_id, 'post_id' => $post_id ]);
    }

    /**
     * @param $post_id
     * @return mixed
     */
    public function detachFromCategory($post_id)
    {
        $sql = "DELETE FROM post_rubric WHERE post_id=:post_id";
        $stmt = $this->c->get('db')->prepare($sql);
        return $stmt->execute([ 'post_id' => $post_id ]);
    }
}