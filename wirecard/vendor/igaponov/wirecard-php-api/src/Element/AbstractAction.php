<?php

namespace Wirecard\Element;

abstract class AbstractAction
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var Transaction
     */
    public $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}
