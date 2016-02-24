<?php

namespace Wirecard\Element;

use Wirecard\Element\Request;
use Wirecard\Element\Response;
use Wirecard\Element\WireCard;

class WireCardTest extends \PHPUnit_Framework_TestCase
{
    public function testWireCardHasRequest()
    {
        $request = $this->getMockBuilder('\Wirecard\Element\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $wireCard = WireCard::createWithRequest($request);
        $this->assertInstanceOf('\Wirecard\Element\Request', $wireCard->request);
    }

    public function testWireCardHasResponse()
    {
        $response = $this->getMockBuilder('\Wirecard\Element\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $wireCard = WireCard::createWithResponse($response);
        $this->assertInstanceOf('\Wirecard\Element\Response', $wireCard->response);
    }
}
 