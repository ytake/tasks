<?php

namespace Ytake\ContentSerializer\Console;

use Symfony\Component\Process\Process;
use Illuminate\Contracts\Config\Repository;
use Ytake\ContentSerializer\TaskCollection;
use Ytake\ContentSerializer\Client\Processor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RunCommand
 */
class RunCommand extends AbstractCommand
{
    /** @var string  command name */
    protected $command = 'tasks:run';

    /** @var string  command description */
    protected $description = 'run tasks';

    /** @var \Illuminate\Contracts\Config\Repository */
    protected $config;

    /**
     * PublishCommand constructor.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        parent::__construct();
        $this->config = $config;
    }

    /**
     *
     */
    protected function arguments()
    {

    }

    protected function action(InputInterface $input, OutputInterface $output)
    {
        $tasks = $this->config->get('tasks');
        $collection = (new TaskCollection())->append($tasks);

        foreach ($collection->getCollection() as $task) {
            $name = ($task->name) ? $task->name : 'task';
            $output->write('<info>[start:' . $name . ']</info>' . PHP_EOL);

            $this->getRemoteProcessor($task->parallel)->run($task, function ($type, $host, $line) use ($output) {
                $this->displayOutput($type, $host, $line, $output);
            });
            $output->write('<info>[end:' . $name . ']</info>' . PHP_EOL);
        }
    }

    /**
     * @param string                                            $type
     * @param string                                            $host
     * @param string                                            $line
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function displayOutput($type, $host, $line, OutputInterface $output)
    {
        $lines = explode("\n", $line);

        foreach ($lines as $line) {
            if (strlen(trim($line)) === 0) {
                return;
            }

            if ($type == Process::OUT) {
                $output->write('<comment>[' . $host . ']</comment>: ' . trim($line) . PHP_EOL);
            } else {
                $output->write('<comment>[' . $host . ']</comment>: <error>' . trim($line) . '</error>' . PHP_EOL);
            }
        }
    }

    /**
     * @param bool $parallel
     *
     * @return \Ytake\ContentSerializer\Client\ParallelSSH|\Ytake\ContentSerializer\Client\SSH
     */
    protected function getRemoteProcessor($parallel)
    {
        return (new Processor)->getProcessor($parallel);
    }
}
