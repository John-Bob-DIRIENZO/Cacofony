<?php

namespace App\Core\Trait;

trait DirectoryParser
{
    public function getClasses(string $directory, array &$results = [])
    {

        $toRemove = implode('/', array_diff(explode('/', __DIR__), explode('\\', __NAMESPACE__)));
        $baseNamespace = array_diff(explode('\\', __NAMESPACE__), explode('/', __DIR__))[0];

        $files = scandir($directory);

        foreach ($files as $file) {
            $realPath = realpath($directory . DIRECTORY_SEPARATOR . $file);
            if (!is_dir($realPath)) {
                $filename = pathinfo($realPath)['filename'];
                $namespace = str_replace('/', '\\', $baseNamespace . str_replace($toRemove, '', pathinfo($realPath)['dirname']));
                $results[] = $namespace . '\\' . $filename;
            } elseif ($file !== '.' && $file !== '..') {
                $this->getClasses($realPath, $results);
            }
        }

        return $results;
    }
}
