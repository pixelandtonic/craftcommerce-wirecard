<?php

namespace Wirecard\Element;

class TransactionTest extends \PHPUnit_Framework_TestCase
{
    public function testTransactionHasIdAmountCurrencyAndCountryCode()
    {
        $creditCardData = $this->getMockBuilder('\Wirecard\Element\CreditCardData')
            ->disableOriginalConstructor()
            ->getMock();
        $trustCenterData = $this->getMockBuilder('\Wirecard\Element\TrustCenterData')
            ->disableOriginalConstructor()
            ->getMock();
        $processingStatus = $this->getMockBuilder('\Wirecard\Element\ProcessingStatus')
            ->disableOriginalConstructor()
            ->getMock();
        $secure = $this->getMockBuilder('\Wirecard\Element\Secure')
            ->disableOriginalConstructor()
            ->getMock();
        $transaction = new Transaction();
        $transaction->amount = 100;
        $transaction->currency = 'RUR';
        $transaction->countryCode = 'RU';
        $transaction->guWid = 'C242720181323966504820';
        $transaction->creditCardData = $creditCardData;
        $transaction->trustCenterData = $trustCenterData;
        $transaction->processingStatus = $processingStatus;
        $transaction->secure = $secure;

        $this->assertSame(100, $transaction->amount);
        $this->assertSame('RUR', $transaction->currency);
        $this->assertSame('RU', $transaction->countryCode);
        $this->assertSame('C242720181323966504820', $transaction->guWid);
        $this->assertInstanceOf('\Wirecard\Element\CreditCardData', $transaction->creditCardData);
        $this->assertInstanceOf('\Wirecard\Element\TrustCenterData', $transaction->trustCenterData);
        $this->assertInstanceOf('\Wirecard\Element\ProcessingStatus', $transaction->processingStatus);
        $this->assertInstanceOf('\Wirecard\Element\Secure', $transaction->secure);
    }
}
 