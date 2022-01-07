<?php

namespace App\Core\Factory;

class PDOFactory
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
        return new \PDO('mysql:host=db;dbname=' . $_ENV['MYSQL_DATABASE'], $this->user, $_ENV['MYSQL_ROOT_PASSWORD'], array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC));
    }

    private function getPostgresConnection()
    {
        // TODO - add real connection
    }

    public static function getInstance(string $type = PDOFactory::MYSQL): \PDO
    {
        if (!isset(self::$instances[$type])) {
            self::$instances[$type] = new PDOFactory($type);
        }

        return self::$instances[$type]->pdo;
    }
}