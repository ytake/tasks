<?php

namespace Ytake\ContentSerializer\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Class AbstractCommand
 */
abstract class AbstractCommand extends Command
{
    /** @var string  command name */
    protected $command;

    /** @var string  command description */
    protected $description;

    /**
     * @return mixed
     */
    abstract protected function arguments();

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return mixed
     */
    abstract protected function action(InputInterface $input, OutputInterface $output);

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->action($input, $output);
    }

    /**
     * command interface configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName($this->command);
        $this->setDescription($this->description);
        $this->arguments();
    }
}
