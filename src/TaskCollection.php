<?php

namespace Ytake\ContentSerializer;

/**
 * Class TaskCollection
 */
class TaskCollection
{
    /** @var Task[]  */
    protected $collection = [];

    /**
     * @param array $tasks
     *
     * @return $this
     */
    public function append(array $tasks = [])
    {
        foreach($tasks as $task => $configure) {
            foreach($configure['hosts'] as $host) {
                list($user, $host) = ($this->parse($host));
                $this->collection[] = new Task(
                    [$host], $user, implode('', $configure['scripts']), $configure['parallel'], $task
                );
            }
        }

        return $this;
    }

    /**
     * @return \Ytake\ContentSerializer\Task[]
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     *
     * @param string $host
     *
     * @return string[]
     */
    protected function parse($host)
    {
        return str_contains($host, '@') ? explode('@', $host) : [null, $host];
    }
}
