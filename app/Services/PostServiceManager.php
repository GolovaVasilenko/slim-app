<?php

namespace App\Services;


use App\Controllers\MediaController;
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

    /**
     * @param $post_id
     * @param $image_id
     * @return mixed
     */
    public function attachImage($post_id, $image_id)
    {
        $sql = "INSERT INTO node_media (node_id, media_id) VALUES (:node_id, :media_id)";
        $stmt = $this->c->get('db')->prepare($sql);
        return $stmt->execute([ 'node_id' => $post_id, 'media_id' => $image_id ]);
    }

    /**
     * @param $post_id
     * @return mixed
     */
    public function detachImage($post_id)
    {
        $sql = "DELETE FROM node_media WHERE node_id=:post_id";
        $stmt = $this->c->get('db')->prepare($sql);
        return $stmt->execute([ 'post_id' => $post_id ]);
    }

    public function removeImage($post_id)
    {
        $mc = new MediaController($this->c);
        $post = $this->find($post_id);
        $image = $post->getImage();
        return $mc->removeImage($image['url']);
    }
}