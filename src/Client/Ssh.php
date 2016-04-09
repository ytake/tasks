<?php

namespace Ytake\ContentSerializer\Client;

use Closure;
use Ytake\ContentSerializer\Task;

/**
 * Class SSH
 */
class SSH extends RemoteProcessor
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
        foreach ($processes as $host => $process) {
            $process->run(function ($type, $output) use ($host, $callback) {
                $callback($type, $host, $output);
            });
        }

        return $this->gatherExitCodes($processes);
    }
}
