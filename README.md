# Laravel Gadgets Dependency

This package provides a possibility to lazy load dependencies using attribute.

## Installation

You can install the package via composer:

```bash
composer require rlempa/laravel-gadgets-dependency
```

### Security

If you discover any security related issues, please email rlempa@gmail.com instead of using the issue tracker.

## Usage

Trait is required to be used.

```php
new class {
    use UseDependency;

    #[Dependency]
    readonly protected ExampleClass $service;

    public function hello(): string
    {
        return $this->service->hello();
    }
};
```

## Development

To start developing first you must install the dependencies:

```bash
docker run --rm -v $(pwd):/app composer install
```

### Testing

To test the package you can run:

```bash
docker run --rm -v $(pwd):/app -w /app php:8.3-cli vendor/bin/pest
```
