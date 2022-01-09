<?php

namespace Cacofony;

use App\Core\Trait\DirectoryParser;

class Test
{
    use DirectoryParser;

    public function test(string $src): array
    {
        return $this->getClassesFromDirectory($src);
    }
}