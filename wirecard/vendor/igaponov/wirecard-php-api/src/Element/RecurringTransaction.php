<?php

namespace Wirecard\Element;

class RecurringTransaction
{
    const TYPE_SINGLE = 'Single';

    const TYPE_INITIAL = 'Initial';

    const TYPE_REPEATED = 'Repeated';

    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }
}
