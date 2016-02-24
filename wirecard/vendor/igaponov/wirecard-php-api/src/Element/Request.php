<?php

namespace Wirecard\Element;

class Request
{
    /**
     * @var Job
     */
    public $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }
}
 