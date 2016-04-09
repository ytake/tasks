<?php

namespace Ytake\ContentSerializer\Client;

use Closure;
use Ytake\ContentSerializer\Task;
use Symfony\Component\Process\Process;

/**
 * Class RemoteProcessor
 */
abstract class RemoteProcessor
{
    /**
     * @param \Ytake\ContentSerializer\Task $task
     * @param \Closure|null                 $callback
     *
     * @return mixed
     */
    abstract public function run(Task $task, Closure $callback = null);

    /**
     * @param string                        $host
     * @param \Ytake\ContentSerializer\Task $task
     *
     * @return string[]
     */
    protected function getProcess($host, Task $task)
    {
        $target = $this->getConfiguredServer($host) ?: $host;

        if (in_array($target, ['local', 'localhost', '127.0.0.1'])) {
            $process = new Process($task->script);
        } else {
            $delimiter = 'EOF-PUBLISHER';
            $process = new Process(
                "ssh $target 'bash -se' << \\$delimiter" . PHP_EOL
                . 'set -e' . PHP_EOL
                . $task->script . PHP_EOL
                . $delimiter
            );
        }

        return [$target, $process->setTimeout(null)];
    }

    /**
     * @param array $processes
     *
     * @return int
     */
    protected function gatherExitCodes(array $processes)
    {
        $code = 0;

        foreach ($processes as $process) {
            $code = $code + $process->getExitCode();
        }

        return $code;
    }
}
