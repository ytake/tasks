<?php

namespace Ytake\ContentSerializer\Client;

use Closure;
use Ytake\ContentSerializer\Task;
use Symfony\Component\Process\Process;

/**
 * Class ParallelSSH
 */
class ParallelSSH extends RemoteProcessor
{
    use ConfigurationParser;

    /**
     * @param \Ytake\ContentSerializer\Task $task
     * @param \Closure|null                 $callback
     *
     * @return int
     */
    public function run(Task $task, Closure $callback = null)
    {
        $processes = [];
        $callback = $callback ?: function () {
        };

        foreach ($task->hosts as $host) {
            $process = $this->getProcess($host, $task);

            $processes[$process[0]] = $process[1];
        }

        $this->startProcesses($processes);
        while ($this->areRunning($processes)) {
            $this->gatherOutput($processes, $callback);
        }
        $this->gatherOutput($processes, $callback);

        return $this->gatherExitCodes($processes);
    }

    /**
     * Start all of the processes.
     *
     * @param  array $processes
     *
     * @return void
     */
    protected function startProcesses(array $processes)
    {
        foreach ($processes as $process) {
            $process->start();
        }
    }

    /**
     * Determine if any of the processes are running.
     *
     * @param  array $processes
     *
     * @return bool
     */
    protected function areRunning(array $processes)
    {
        foreach ($processes as $process) {
            if ($process->isRunning()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gather the output from all of the processes.
     *
     * @param  array    $processes
     * @param  \Closure $callback
     *
     * @return void
     */
    protected function gatherOutput(array $processes, Closure $callback)
    {
        foreach ($processes as $host => $process) {
            $methods = [
                Process::OUT => 'getIncrementalOutput',
                Process::ERR => 'getIncrementalErrorOutput',
            ];

            foreach ($methods as $type => $method) {
                $output = $process->{$method}();

                if (!empty($output)) {
                    $callback($type, $host, $output);
                }
            }
        }
    }
}
