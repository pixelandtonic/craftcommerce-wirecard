<?php

namespace Wirecard\Element;

class Error 
{
    public $type;

    public $number;

    public $message;

    public $advices = [];

    public function __construct($type, $number, $message)
    {
        $this->type = $type;
        $this->number = $number;
        $this->message = $message;
    }

    public function getAdvicesAsString()
    {
        return implode(' ', $this->advices);
    }
}
 