<?php

namespace Cacofony\Factory;

use Cacofony\Interfaces\FactoryInterface;

class PDOFactory implements FactoryInterface
{
    private string $user = 'root';
    private static array $instances = [];
    private \PDO $pdo;

    // Just to check if my Singleton work
    public string $uniqID;

    const MYSQL = 'getMysqlConnection';
    const POSTGRESQL = 'getPostgresConnection';

    private function __construct(string $type)
    {
        $this->uniqID = uniqid();

        $this->pdo = match ($type) {
            'getMysqlConnection' => $this->getMysqlConnection(),
            'getPostgresConnection' => $this->getPostgresConnection(),
            default => throw new \InvalidArgumentException('La DB demandé n\'est pas disponible'),
        };
    }

    private function __clone(): void
    {
        // Leave this empty, you should not be able to clone an instance in a Singleton
    }

    private function getMysqlConnection(): \PDO
    {
        return new \PDO('mysql:host=db;dbname=' . $_ENV['MYSQL_DATABASE'], $this->user, $_ENV['MYSQL_ROOT_PASSWORD']);
    }

    private function getPostgresConnection()
    {
        // TODO - add real connection
    }

    public function getPDO(): \PDO
    {
        return $this->pdo;
    }

    public static function getInstance(string $type = PDOFactory::MYSQL): PDOFactory
    {
        if (!isset(self::$instances[$type])) {
            self::$instances[$type] = new PDOFactory($type);
        }

        return self::$instances[$type];
    }
}