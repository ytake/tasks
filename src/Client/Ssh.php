<?php

namespace Ytake\ContentSerializer\Client;

use phpseclib\Net\SSH2;

/**
 * Class Ssh
 */
class Ssh implements SshConnectionInterface
{
    /** @var array */
    protected $configure;

    /**
     * Ssh constructor.
     *
     * @param array $configure
     */
    public function __construct(array $configure)
    {
        $this->configure = $configure;
    }

    /**
     * @param $hostname
     *
     * @return SSH2
     */
    public function connect($hostname)
    {
        if (isset($this->configure[$hostname])) {

        }
        $ssh = new SSH2($hostname);
        $ssh->login($this->configure[$hostname]['username'], $this->configure[$hostname]['password']);
        return $ssh;
    }
}
