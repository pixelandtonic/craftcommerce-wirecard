<?php

namespace Wirecard\Element;

class CreditCardDataTest extends \PHPUnit_Framework_TestCase
{
    public function testCreditCardDataConstruction()
    {
        $card = new CreditCardData();
        $card->creditCardNumber = '4231231';
        $card->setExpirationDate('2014-10');
        $card->cardHolderName = 'John Doe';
        $card->secureCode = '123';

        $this->assertSame('4231231', $card->creditCardNumber);
        $this->assertSame('2014', $card->expirationYear);
        $this->assertSame('10', $card->expirationMonth);
        $this->assertSame('John Doe', $card->cardHolderName);
        $this->assertSame('123', $card->secureCode);
    }
}
 