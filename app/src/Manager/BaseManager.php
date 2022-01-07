<?php

namespace App\Manager;

use App\Core\Factory\PDOFactory;
use App\Core\Trait\Hydrator;

abstract class BaseManager
{
    use Hydrator;
    protected \PDO $pdo;
    protected string $table;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->table = $this->resolveTableName();
    }

    public function tableExist($table): bool
    {
        $req = $this->pdo->prepare( "DESCRIBE `$table`");
        return $req->execute();
    }

    public function count($table) : int
    {
        $req = $this->pdo->prepare( "SELECT COUNT(*) as count FROM $table");
        $req->execute();
        $result = $req->fetch();
        return $result["count"];
    }

    private function resolveTableName() {
       return str_replace("Manager", "", (new \ReflectionClass($this))->getShortName());
    }

    public function insert($objects) {

        $objects = (gettype($objects) == "array") ? $objects : [$objects];
        foreach ($objects as $object) {
            $datas = $this->dehydrate($object);
            $tableKeys = "";
            $preparedKeys = "";
            foreach ($datas as $key => $data) {
                $tableKeys .= "$key,";
                $preparedKeys .= "?,";
                $preparedArray[] = $data;
            }
        }

        $keys = rtrim($tableKeys, ',');
        $preparedKeys = rtrim($preparedKeys, ',');
        $req = $this->pdo->prepare("INSERT INTO $this->table ($keys) VALUES ($preparedKeys)");
        return $req->execute($preparedArray);
    }
}