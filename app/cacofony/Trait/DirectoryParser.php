<?php

namespace Cacofony\Trait;

trait DirectoryParser
{
    use FileParser;

    /**
     * Returns an array with the complete classes names from a directory and its subdirectories
     * @param string $directory
     * @param array $results
     * @return array
     */
    public function getClassesFromDirectory(string $directory, array &$results = []): array
    {
        $autoload = $this->getNamespacesFromComposerJson('/var/www/html/composer.json');

        $files = scandir($directory);

        foreach ($files as $file) {
            $realPath = realpath($directory . DIRECTORY_SEPARATOR . $file);

            if (!is_dir($realPath)) {
                foreach ($autoload as $namespace => $dir) {
                    $path = stristr($realPath, trim($dir, '/'));
                    if ($path) {
                        $extension = '.' . pathinfo($realPath)["extension"];
                        $dirnameReplacedByNamespace = str_replace($dir, $namespace, $path);
                        $withBackSlash = str_replace('/', '\\', $dirnameReplacedByNamespace);
                        $results[] = str_replace($extension, '', $withBackSlash);
                    }
                }
            } elseif ($file !== '.' && $file !== '..') {
                $this->getClassesFromDirectory($realPath, $results);
            }
        }

        return $results;
    }
}
