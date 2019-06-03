<?php


namespace App\Services;


use App\Models\Rubric;

class RubricServiceManager extends AbstractServiceManager
{

    /**
     * @return mixed
     */
    public static function getTable()
    {
        return Rubric::TABLE;
    }

    /**
     * @return mixed
     */
    public static function getClass()
    {
        return Rubric::class;
    }
}