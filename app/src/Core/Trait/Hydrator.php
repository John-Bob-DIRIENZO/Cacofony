<?php

namespace App\Core\Trait;

trait Hydrator
{
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }
    }

    public function dehydrate(object $object)
    {
        $entityName = (new \ReflectionClass($object))->getShortName();
        $methods = get_class_methods($object);
        foreach ($methods as $method) {
            if (substr($method, 0, 3) == "get" && $method !== "getId$entityName") {
                $data[substr($method, 3)] = $object->{$method}();
            }
        }
        return $data;
    }
}