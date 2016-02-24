<?php

namespace Wirecard\Element;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testRequestHasJob()
    {
        $job = $this->getMockBuilder('\Wirecard\Element\Job')
            ->disableOriginalConstructor()
            ->getMock();

        $request = new Request($job);
        $this->assertInstanceOf('\Wirecard\Element\Job', $request->job);
    }
}
 