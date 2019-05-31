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

}