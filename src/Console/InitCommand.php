<?php

namespace Ytake\ContentSerializer\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InitCommand
 */
class InitCommand extends AbstractCommand
{
    /** @var string  command name */
    protected $command = 'tasks:init';

    /** @var string  command description */
    protected $description = 'publish to configuration file';

    /**
     *
     */
    protected function arguments()
    {

    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return mixed
     */
    protected function action(InputInterface $input, OutputInterface $output)
    {
        $result = copy(__DIR__ .'/../data/configure.php', $current = getcwd() . '/tasks.php');
        if($result) {
            return $output->write("<info>[publish to:{$current}]</info>" .PHP_EOL);
        }
        return $output->write("<error>[error occurred:{$current}]</error>" .PHP_EOL);
    }
}
