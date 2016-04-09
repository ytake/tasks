<?php

namespace Ytake\ContentSerializer;

/**
 * Class Task
 */
class Task
{
    /** @var string[]  */
    public $hosts = [];

    /** @var   */
    public $user;

    /** @var   */
    public $script;

    /** @var bool  */
    public $parallel;

    /** @var null  */
    public $name;

    /**
     * Task constructor.
     *
     * @param array $hosts
     * @param       $user
     * @param       $script
     * @param bool  $parallel
     */
    public function __construct(array $hosts, $user, $script, $parallel = false, $name = null)
    {
        $this->user = $user;
        $this->hosts = $hosts;
        $this->script = $script;
        $this->parallel = $parallel;
        $this->name = $name;
    }
}
