<?php

namespace Ytake\ContentSerializer\Console;

use Illuminate\Contracts\Config\Repository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PublishCommand
 */
class PublishCommand extends AbstractCommand
{
    /** @var string  command name */
    protected $command = 'content:publish';

    /** @var string  command description */
    protected $description;

    public function __construct(Repository $config)
    {
        parent::__construct();
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
//         var_dump($this->ssh);
        // TODO: Implement action() method.
    }
    
    protected function getRemoteProcessor()
    {
        
    }
}
