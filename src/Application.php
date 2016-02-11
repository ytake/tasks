<?php

namespace Ytake\ContentSerializer;

use League\Container\Container;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Application
 */
class Application extends \Symfony\Component\Console\Application
{
    /** @var string  console application name */
    private $name = 'content-serializer';

    /** @var float  console application version */
    private $version = 0.1;

    /** @var ContainerInterface|Container  */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        parent::__construct($this->name, $this->version);
        $this->container = (is_null($container)) ? new Container : $container;
    }

    /**
     * @param InputInterface|null  $input
     * @param OutputInterface|null $output
     *
     * @return int|void
     * @throws \Exception
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        parent::run($input, $output);
    }

    /**
     * @param array $command
     */
    public function registerCommands(array $command)
    {
        $this->addCommands($command);
    }
}
