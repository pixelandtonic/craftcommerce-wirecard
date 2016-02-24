<?php

namespace Wirecard\Element;

class ProcessingStatusTest extends \PHPUnit_Framework_TestCase
{
    public function testProcessingStatusHasIdCodeTypeResultAndTimeStamp()
    {
        $status = new ProcessingStatus('', 'Y', 'ACK');
        $this->assertTrue($status->isEligible());
        $this->assertTrue($status->isSuccessful());
    }
}
 