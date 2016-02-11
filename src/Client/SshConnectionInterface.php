<?php

namespace Ytake\ContentSerializer\Client;

/**
 * Interface SshConnectionInterface
 *
 * @package Ytake\ContentSerializer\Client
 */
interface SshConnectionInterface
{
    /**
     * @param $hostname
     */
    public function connect($hostname);
}
