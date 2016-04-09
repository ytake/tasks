<?php

namespace Ytake\ContentSerializer;

use Illuminate\Contracts\Config\Repository;
use League\Container\ContainerInterface;

/**
 * Class Dependency
 */
class Dependency
{
    /** @var string $path */
    protected $path = __DIR__ . '/data/configure.php';

    /**
     * @param string $path application path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param ContainerInterface $container
     */
    public function define(ContainerInterface $container)
    {
        $container->add('app://path', $this->path);
        if (file_exists($taskFile = getcwd() . '/tasks.php')) {
            $container->add('app://path', $taskFile);
            $this->path = $taskFile;
        }

        $container->add(Repository::class, function () {
            return new \Illuminate\Config\Repository(require $this->path);
        });
    }
}
