<?php

namespace Cacofony\BaseClasse;

use Cacofony\Trait\Hydrator;

abstract class BaseEntity
{
    use Hydrator;



//    public function __get(string $name)
//    {
//        $method = 'get' . ucfirst($name);
//        if (is_callable([$this, $method])) {
//            return $this->$method();
//        }
//    }
//
//    public function __set(string $name, string $value)
//    {
//        $method = 'set' . ucfirst($name);
//        if (is_callable([$this, $method])) {
//            return $this->$method($value);
//        }
//    }

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

//    public function __serialize(): array
//    {
//        $reflection = new \ReflectionClass($this);
//        foreach ($reflection->getProperties() as $property) {
//            $method = 'get' . ucfirst($property->getName());
//            if (is_callable([$this, $method])) {
//                $return[$property->getName()] = $this->$method();
//            }
//        }
//        return $return ?? [];
//    }
}