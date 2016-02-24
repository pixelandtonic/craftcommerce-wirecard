<?php

namespace Wirecard\Element\Action;

use Wirecard\Element\AbstractAction;
use Wirecard\Element\Transaction;

class Query extends AbstractAction
{
    const TYPE_DETAIL = 'detail';

    public $type;

    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
    }
}
