<?php

namespace App\Core\Interfaces;

use App\Core\Factory\PDOFactory;

interface FactoryInterface
{
    public function getPDO(): \PDO;
    public static function getInstance(string $type): PDOFactory;
}