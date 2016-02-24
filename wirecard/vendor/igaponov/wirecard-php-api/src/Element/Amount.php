<?php

namespace Wirecard\Element;

class Amount
{
    const ACTION_CONVERT = 'convert';

    const ACTION_VALIDATE = 'validate';

    public $value;

    public $units;

    public $action;

    public function __construct($value, $units = 2, $action = self::ACTION_VALIDATE)
    {
        $this->value = (int)bcmul($value, 100);
        $this->units = $units;
        $this->action = $action;
    }
}
