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
}