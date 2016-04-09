<?php

namespace Ytake\ContentSerializer\Client;

use Illuminate\Contracts\Config\Repository;

/**
 * Class Processor
 * @package Ytake\ContentSerializer\Client
 */
class Processor
{
    /** @var Repository  */
    private $config;

    /**
     * Processor constructor.
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function getRemoteProcessor()
    {
        if($this->config->get('parallel', false)) {
            return new ParallelSSH();
        }
        return new SSH();
    }
}
