<?php

namespace App\Services;

use App\Services\DbServiceManagerInterface;
use Psr\Container\ContainerInterface;


abstract class AbstractServiceManager implements DbServiceManagerInterface
{
    protected $c;

    /**
     * AbstractServiceManager constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->c = $container;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->c->get('db')->query("SELECT * FROM " . static::getTable())->fetchAll(\PDO::FETCH_CLASS, static::getClass());
    }

    /**
     * @param $column
     * @param $value
     * @return mixed
     */
    public function findByColumn($column, $value)
    {
        $stmt = $this->c->get('db')->prepare("SELECT * FROM " . static::getTable() . " WHERE " . $column . "=:val");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, static::getClass());
        $stmt->execute(['val' => $value]);
        return $stmt->fetch();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $prepare = $this->c->get('db')->prepare("SELECT * FROM " . static::getTable() . " WHERE id=:id");
        $prepare->setFetchMode(\PDO::FETCH_CLASS, static::getClass());
        $prepare->execute(['id' => $id]);

        return $prepare->fetch();
    }

    /**
     * @param $data
     * @return mixed
     */
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

    /**
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        $sql = "INSERT INTO " . static::getTable() . " (" . implode(',', array_keys($data)) . ") VALUES (:" . implode(',:', array_keys($data)) . ")";
        $stmt = $this->c->get('db')->prepare($sql);
        $stmt->execute($data);
        return $this->c->get('db')->lastInsertId();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function remove($id)
    {
        $sql = "DELETE FROM " . static::getTable() . " WHERE id=:id";
        $stmt = $this->c->get('db')->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * @return mixed
     */
    abstract public static function getTable();

    /**
     * @return mixed
     */
    abstract public static function getClass();
}