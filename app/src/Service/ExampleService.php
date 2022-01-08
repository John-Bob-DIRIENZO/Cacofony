<?php

namespace App\Service;

class ExampleService
{
    private string $appSecret;
    private int $test;

    public function __construct(string $appSecret, int $test)
    {
        $this->appSecret = $appSecret;
        $this->test = $test;
    }

    public function getStrong(string $text): string
    {
        return "<strong>$text</strong>";
    }

    public function getAppSecret(): string
    {
        return $this->appSecret . ' | ' . $this->test;
    }
}