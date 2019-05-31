<?php


namespace App\Services;

use App\Models\Page;
use App\Services\AbstractServiceManager;

class PageServiceManager extends AbstractServiceManager
{

    public static function getTable()
    {
        return Page::TABLE;
    }

    public static function getClass()
    {
        return Page::class;
    }

}