<?php

namespace Cacofony\Trait;

trait FileParser
{
    public function getNamespacesFromComposerJson(string $file)
    {
        if (!file_exists($file)) {
            throw new \InvalidArgumentException('Ficher non trouvé');
        }

        $json = json_decode(file_get_contents($file), true);
        return $json['autoload']['psr-4'];
    }

}