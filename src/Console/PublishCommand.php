<?php

namespace Ytake\ContentSerializer\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ytake\ContentSerializer\Client\Ssh;

/**
 * Class PublishCommand
 */
class PublishCommand extends AbstractCommand
{
    use Setter;

    /** @var string  command name */
    protected $command = 'content:publish';

    /** @var string  command description */
    protected $description;

    /** @var Ssh  */
    protected $ssh;

    /**
     * @param Ssh $ssh
     */
    public function setDependency(Ssh $ssh)
    {
        $this->ssh = $ssh;
    }

    /**
     *
     */
    protected function arguments()
    {
        /*
        $this->addOption(
            'iterations',
            null,
            InputOption::VALUE_REQUIRED,
            'How many times should the message be printed?',
            1
        );
        */
    }

    protected function action(InputInterface $input, OutputInterface $output)
    {
        var_dump($this->ssh);
        // TODO: Implement action() method.
    }
}
