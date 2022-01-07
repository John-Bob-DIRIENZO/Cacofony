<?php

namespace App\Manager;

use App\Core\Factory\PDOFactory;

abstract class BaseManager
{
    protected \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
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

    public function delete($id) {

    }
}