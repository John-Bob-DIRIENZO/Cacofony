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
        $this->table = str_replace("Manager", "", (new \ReflectionClass($this))->getShortName());
    }

    public function tableExist($table): bool
    {
        $req = $this->pdo->prepare( "DESCRIBE `$table`");
        return $req->execute();
    }

    public function count($wheres = null, $options = ["limit" => null, "order" => null]): int
    {
        $req = "SELECT COUNT(*) as count FROM $this->table";

        $whereMaker = $this->whereMaker($wheres, $options);
        $req .= $whereMaker["where"];

        $req = $this->pdo->prepare( $req);
        $req->execute($whereMaker["values"]);
        return $req->fetch()["count"];
    }

    public function find($columns = "*", $wheres = null, $options = ["limit" => null, "order" => null]): array {
        $req = "SELECT $columns FROM $this->table";

        $whereMaker = $this->whereMaker($wheres, $options);
        $req .= $whereMaker["where"];

        $req = $this->pdo->prepare($req);
        $req->execute($whereMaker["values"]);
        return $req->fetchAll();
    }

    public function insert($objects): bool {

        $objects = (gettype($objects) == "array") ? $objects : [$objects];
        foreach ($objects as $object) {
            $datas = $this->dehydrate($object);
            $tableKeys = "";
            $preparedKeys = "";
            $preparedValues = null;
            foreach ($datas as $key => $data) {
                $tableKeys .= "$key,";
                $preparedKeys .= "?,";
                $preparedValues[] = $data;
            }
        }

        $keys = rtrim($tableKeys, ',');
        $preparedKeys = rtrim($preparedKeys, ',');
        $req = $this->pdo->prepare("INSERT INTO $this->table ($keys) VALUES ($preparedKeys)");
        return $req->execute($preparedValues);
    }

    public function update($datas, $wheres = null, $options = ["limit" => null, "order" => null]): bool {
        $req = "UPDATE $this->table SET ";

        $preparedValues = null;
        $i = 0;
        foreach ($datas as $key => $data) {
            if ($i > 0) $req .= ", ";
            $req .= "$key = ?";
            $preparedValues[] = $data;
        }

        $whereMaker = $this->whereMaker($wheres, $options);
        $req .= $whereMaker["where"];
        $preparedValues = array_merge($preparedValues, $whereMaker["values"]);

        $req = $this->pdo->prepare($req);
        return $req->execute($preparedValues);
    }

    public function delete($wheres = null, $options = ["limit" => null, "order" => null]): bool {
        $req = "DELETE FROM $this->table";
        $whereMaker = $this->whereMaker($wheres, $options);
        $req .= $whereMaker["where"];
        $req = $this->pdo->prepare($req);
        return $req->execute($whereMaker["values"]);
    }

    private function whereMaker($wheres, $options): array {
        $req = null;
        $preparedValues = null;

        if (!empty($wheres)) {
            $req .= " WHERE ";
                $i = 0;
                foreach ($wheres as $column => $value) {
                    if ($i > 0) $req .= "AND";
                    $req .= " " . $column . " ? ";
                    $preparedValues[] = $value;
                    $i++;
                }
        } else $req .= " WHERE 1 ";

        if (!empty($options["order"]))
            $req .= " ORDER BY ".$options["order"];
        if (!empty($options["limit"]))
            $req .= " LIMIT ".$options["limit"];

        return array("where" => $req, "values" => $preparedValues);
    }

}