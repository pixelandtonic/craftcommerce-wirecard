<?php

namespace Wirecard\Element;

use DateTime;

class CreditCardData
{
    public $creditCardNumber;

    public $expirationYear;

    public $expirationMonth;

    public $cardHolderName;

    public $secureCode;

    public function setExpirationDate($date)
    {
        $date = new DateTime($date);
        $this->expirationYear = $date->format('Y');
        $this->expirationMonth = $date->format('m');
    }
}
 