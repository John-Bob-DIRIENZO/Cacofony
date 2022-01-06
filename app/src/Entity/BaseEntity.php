<?php

namespace App\Entity;

use App\Core\Trait\Hydrator;

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
}