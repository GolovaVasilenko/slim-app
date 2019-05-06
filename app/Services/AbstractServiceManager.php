<?php

namespace app\Services;

use App\Services\DbServiceManagerInterface;
use Psr\Container\ContainerInterface;


abstract class AbstractServiceManager implements DbServiceManagerInterface
{
    protected $c;

    public function __construct(ContainerInterface $container)
    {
        $this->c = $container;
    }

    public function all()
    {
        return $this->c->get('db')->query("SELECT * FROM " . static::getTable())->fetchAll(\PDO::FETCH_CLASS, static::getClass());
    }

    public function find($id)
    {
        $prepare = $this->c->get('db')->prepare("SELECT * FROM " . static::getTable() . " WHERE id=:id");
        $prepare->setFetchMode(\PDO::FETCH_CLASS, static::getClass());
        $prepare->execute(['id' => $id]);

        return $prepare->fetch();
    }

    public function update($data)
    {
        $res = [];
        $prepare = [];

        foreach($data as $key => $value) {
            $res[$key] = $value;
            if($key == 'id') continue;
            $prepare[] = $key . '=:' . $key;
        }

        $sql = "UPDATE " . static::getTable() . " SET " . implode(',', $prepare) . " WHERE id=:id";
        $stmt = $this->c->get('db')->prepare($sql);
        return $stmt->execute($data);
    }

    public function insert($data)
    {
        $sql = "INSERT INTO " . static::getTable() . " (" . implode(',', array_keys($data)) . ") VALUES (:" . implode(',:', array_keys($data)) . ")";
        $stmt = $this->c->get('db')->prepare($sql);
        $stmt->execute($data);
        return $this->c->get('db')->lastInsertId();
    }

    public function remove($id)
    {
        $sql = "DELETE FROM " . static::getTable() . " WHERE id=:id";
        $stmt = $this->c->get('db')->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    abstract public static function getTable();

    abstract public static function getClass();
}