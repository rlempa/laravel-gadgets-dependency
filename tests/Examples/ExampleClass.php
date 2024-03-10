<?php

namespace Rlempa\Gadgets\Dependency\Tests\Examples;

class ExampleClass
{
    public const string HELLO = 'hello';

    public function hello(): string
    {
        return self::HELLO;
    }
}