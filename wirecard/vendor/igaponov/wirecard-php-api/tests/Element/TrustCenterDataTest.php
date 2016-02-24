<?php

namespace Wirecard\Element;

class TrustCenterDataTest extends \PHPUnit_Framework_TestCase
{
    public function testTrustCenterDataHasBillingAddress()
    {
        $billingAddress = $this->getMockBuilder('\Wirecard\Element\BillingAddress')
            ->disableOriginalConstructor()
            ->getMock();
        $data = new TrustCenterData($billingAddress);
        $this->assertInstanceOf('\Wirecard\Element\BillingAddress', $data->billingAddress);
    }
}
 