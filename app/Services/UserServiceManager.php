<?php

namespace App\Services;

use App\Models\User;

class UserServiceManager extends AbstractServiceManager
{

    /**
     * @return mixed
     */
    public static function getTable()
    {
        return User::TABLE;
    }

    /**
     * @return mixed
     */
    public static function getClass()
    {
        return User::class;
    }
}