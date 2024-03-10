<?php

namespace Rlempa\Gadgets\Dependency\Traits;

use Illuminate\Support\Collection;
use LogicException;
use ReflectionClass;
use ReflectionException;
use Rlempa\Gadgets\Dependency\Attributes\Dependency;

/**
 * Trait UseDependency handles possibility to lazy load dependency using Dependency attribute.
 *
 * @see Dependency
 */
trait UseDependency
{
    protected Collection $dependencies;

    /**
     * UseDependency constructor.
     */
    public function __construct()
    {
        $this->dependencies = collect();
        $this->collectDependencies();

        if (is_callable('parent::__construct')) {
            /** @noinspection PhpUndefinedClassInspection */
            parent::__construct();
        }
    }

    /** @noinspection MagicMethodsValidityInspection */
    public function __get(string $name)
    {
        if ($this->isDependencyExist($name)) {
            $this->{$name} = $this->loadDependency($name);

            return $this->{$name};
        }

        throw new LogicException('Undefined property "' . $name . '"');
    }

    /**
     * Apply dependencies to class fields.
     *
     * @param string|null $class
     *
     * @return void
     *
     * @throws ReflectionException
     */
    private function collectDependencies(?string $class = null): void
    {
        $reflectionClass = new ReflectionClass($class ?? $this);

        // Iterate through each property
        foreach ($reflectionClass->getProperties() as $property) {
            if (!$property->isInitialized($reflectionClass->newInstanceWithoutConstructor())) {
                $attributes = $property->getAttributes(Dependency::class);
                if (!empty($attributes)) {
                    unset($this->service);
                    $this->dependencies->put($property->getName(), $property->getType()?->getName());
                }
            }
        }

        $parentClass = $reflectionClass->getParentClass();
        if ($parentClass !== false) {
            $this->collectDependencies($parentClass->getName());
        }
    }

    /**
     * Check if provided dependency was defined.
     *
     * @param string $name
     *
     * @return bool
     */
    private function isDependencyExist(string $name): bool
    {
        return $this->dependencies->has($name);
    }

    /**
     * Load dependency from service container.
     *
     * @param string $name
     *
     * @return object
     */
    private function loadDependency(string $name): object
    {
        return app($this->dependencies->get($name));
    }
}
