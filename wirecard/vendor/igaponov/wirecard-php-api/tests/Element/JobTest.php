<?php

namespace Wirecard\Element;

class JobTest extends \PHPUnit_Framework_TestCase
{
    public function testJobHasSignatureAndCheck()
    {
        $enrollmentCheck = $this->getMockBuilder('\Wirecard\Element\Action\EnrollmentCheck')
            ->disableOriginalConstructor()
            ->getMock();
        $job = Job::createEnrollmentJob('0000003164DF5F22', $enrollmentCheck);
        $this->assertEquals(16, strlen($job->signature));
        $this->assertInstanceOf('\Wirecard\Element\Action\EnrollmentCheck', $job->enrollmentCheck);
    }

    public function testJobHasSignatureAndPurchase()
    {
        $purchase = $this->getMockBuilder('\Wirecard\Element\Action\Purchase')
            ->disableOriginalConstructor()
            ->getMock();
        $job = Job::createPurchaseJob('0000003164DF5F22', $purchase);
        $this->assertEquals(16, strlen($job->signature));
        $this->assertInstanceOf('\Wirecard\Element\Action\Purchase', $job->purchase);
    }
}
 