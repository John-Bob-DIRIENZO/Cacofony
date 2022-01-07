<?php

namespace App\Service;

class ExampleService
{
    public function getStrong(string $text): string
    {
        return "<strong>$text</strong>";
    }
}