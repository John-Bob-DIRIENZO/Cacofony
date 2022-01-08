<?php

namespace App\Core\DIC;

use App\Core\Trait\DirectoryParser;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

class DIC implements ContainerInterface
{
    private static array $registry = [];
    private static array $instances = [];

    use DirectoryParser;

    public function set(string $id, callable $resolver): void
    {
        self::$registry[$id] = $resolver;
    }

    public function get(string $id)
    {
        return self::autowire($id);
    }

    public static function autowire(string $id)
    {
        if (!array_key_exists($id, self::$instances)) {
            self::$instances[$id] = self::$registry[$id]();
        }
        return self::$instances[$id];
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, self::$registry);
    }

    public function injectParameters(string $yamlFile): self
    {
        if (!file_exists($yamlFile)) {
            throw new \InvalidArgumentException('Ficher non trouvé');
        }

        foreach (yaml_parse_file($yamlFile)['parameters'] as $name => $parameter) {
            $this->set($name, function () use ($parameter) { return $parameter;});
        }

        return $this;
    }

    /**
     * @throws ReflectionException
     */
    public function run(string $srcDir)
    {
        // This first run is to get all the classes with interfaces and their instanciation method
        foreach ($this->getClassesFromDirectory($srcDir) as $class) {
            if ($interfaces = ($reflection = new \ReflectionClass($class))->getInterfaces()) {
                foreach ($interfaces as $interface) {
                    $this->set($interface->getName(), function () use ($reflection) {
                        try {
                            return $reflection->newInstance();
                        } catch (ReflectionException $e) {
                            return call_user_func([$reflection->getName(), 'getInstance']);
                        }
                    });
                }
            }
        }

        // Second run to get all the classes and inject their dependencies in the constructor
        // We should not add entities and BaseEntity to the container

        // TODO - Récupérer ces infos d'un fichier de config, c'est moche en dur !
        $entities = $this->getClassesFromDirectory(__DIR__ . '/../../Entity');
        $controllers = $this->getClassesFromDirectory(__DIR__ . '/../../Controller');
        $toExclude = array_merge($controllers, $entities, $this->getClassesFromDirectory(__DIR__ . '/../../Core'));

        foreach ($this->getClassesFromDirectory($srcDir) as $class) {
            if (in_array($class, $toExclude)) {
                continue;
            }
            $constructorDependencies = [];
            if (($reflection = new \ReflectionClass($class))->getConstructor()) {
                foreach ($reflection->getConstructor()->getParameters() as $parameter) {
                    // If it's a builtin parameter, it should have been manually injected
                    // to be able to have a unique identifier in the container, the name of a
                    // manually injected parameter is <varType><$varName>
                    if (!$parameter->getType()->isBuiltin()) {
                        $constructorDependencies[] = $this->get($parameter->getType()->getName());
                    } else {
                        $constructorDependencies[] = $this->get($parameter->getType()->getName() . ' $' . $parameter->getName());
                    }
                }
            }
            $this->set($reflection->getName(), function () use ($reflection, $constructorDependencies) {
                return $reflection->newInstanceArgs($constructorDependencies);
            });
        }
    }
}