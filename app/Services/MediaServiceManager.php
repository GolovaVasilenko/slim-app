<?php

namespace App\Services;

use App\Models\Media;

class MediaServiceManager extends AbstractServiceManager
{

    /**
     * @return mixed
     */
    public static function getTable()
    {
        return Media::TABLE;
    }

    /**
     * @return mixed
     */
    public static function getClass()
    {
        return Media::class;
    }
}