<?php


namespace ModernPHP;

class HelloWorld
{
    public function __invoke(): void
    {
        echo 'Hello, autoloaded world!';
        exit;
    }
}