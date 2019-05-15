<?php


namespace app\Services;


interface DbServiceManagerInterface
{
    public function all();

    public function find($id);

    public function update($data);

    public function insert($data);

    public function remove($id);
}