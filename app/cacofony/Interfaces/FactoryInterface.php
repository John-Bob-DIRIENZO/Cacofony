<?php

namespace Cacofony\Interfaces;

use Cacofony\Factory\PDOFactory;

interface FactoryInterface
{
    public function getPDO(): \PDO;
    public static function getInstance(string $type): PDOFactory;
}