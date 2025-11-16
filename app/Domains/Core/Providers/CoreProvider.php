<?php
declare(strict_types=1);

namespace Core\Providers;

use Core\Container\LaravelContainer;
use Core\Contracts\Container\Container;
use Core\Providers\AbstractProvider;
use Core\Contracts\OutputFormat\OutputFormat;
use Core\OutputFormats\JsonFormat;
use Core\Packages\Media\Contracts\MediaStorage;
use Core\Packages\Media\Storage\LaravelStorage;

class CoreProvider extends AbstractProvider
{
    /**
     * bindings.
     *
     * @var array
     */
    public $bindings = [
        OutputFormat::class => JsonFormat::class,
        MediaStorage::class => LaravelStorage::class,
        Container::class => LaravelContainer::class
    ];

    protected $namespace = 'Core\Controllers';
    protected $routePath = __DIR__ . '/../routes/api.php';
}
