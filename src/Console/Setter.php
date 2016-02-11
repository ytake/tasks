<?php

namespace Ytake\ContentSerializer\Console;

/**
 * Class Setter
 */
trait Setter
{
    /**
     * @param array ...$arg
     *
     * @return mixed
     */
    abstract public function setDependency(...$arg);
}
