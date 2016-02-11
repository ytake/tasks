<?php

namespace Ytake\ContentSerializer;

use League\Container\ContainerInterface;

/**
 * Class Dependency
 */
class Dependency
{
    /**
     * @param ContainerInterface $container
     */
    public function define(ContainerInterface $container)
    {
        $container->add('app:configure', [
            'host1',
        ]);
        $container->add(
            'Ytake\ContentSerializer\Client\SshConnectionInterface',
            'Ytake\ContentSerializer\Client\Ssh'
        );
        $container->add('Ytake\ContentSerializer\Client\Ssh')
            ->withArgument('app:configure');

        $container
            ->add('Ytake\ContentSerializer\Console\PublishCommand')
            ->withMethodCall('setDependency',
                [
                    'Ytake\ContentSerializer\Client\Ssh',
                ]
            );
    }
}
