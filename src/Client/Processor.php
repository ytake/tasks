<?php

namespace Ytake\ContentSerializer\Client;

/**
 * Class Processor
 */
class Processor
{
    /**
     * access to processor
     * @param bool $parallel
     *
     * @return \Ytake\ContentSerializer\Client\ParallelSSH|\Ytake\ContentSerializer\Client\SSH
     */
    public function getProcessor($parallel = false)
    {
        if ($parallel) {
            return new ParallelSSH();
        }

        return new SSH();
    }
}
