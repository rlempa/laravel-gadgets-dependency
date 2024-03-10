<?php


use Rlempa\Gadgets\Dependency\Attributes\Dependency;
use Rlempa\Gadgets\Dependency\Tests\Examples\ExampleClass;
use Rlempa\Gadgets\Dependency\Traits\UseDependency;

test('dependency', function () {

    $class = new class {
        use UseDependency;

        #[Dependency]
        readonly protected ExampleClass $service;

        public function hello(): string
        {
            return $this->service->hello();
        }
    };

    expect($class->hello())->toBeString(ExampleClass::HELLO);
});
