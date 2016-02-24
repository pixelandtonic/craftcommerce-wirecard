<?php

namespace Wirecard\Element;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testResponseHasJob()
    {
        $job = $this->getJobMock();

        $response = new Response($job);
        $this->assertInstanceOf('\Wirecard\Element\Job', $response->job);
    }

    public function testIsSuccessfulReturnsFalseOnError()
    {
        $job = $this->getJobMock();

        $response = new Response($job);
        $response->error = true;
        $this->assertFalse($response->isSuccessful());
    }

    public function testIsSuccessfulReturnsFalseOnJobError()
    {
        $job = $this->getJobMock();
        $job->error = true;

        $response = new Response($job);
        $this->assertFalse($response->isSuccessful());
    }

    public function testIsSuccessfulReturnsTransactionResult()
    {
        $job = $this->getJobMock(['getTransaction']);
        $transaction = $this->getMock('\Wirecard\Element\Transaction', ['isSuccessful']);
        $transaction->expects($this->once())->method('isSuccessful')->will($this->returnValue(true));
        $job->expects($this->once())->method('getTransaction')->will($this->returnValue($transaction));

        $response = new Response($job);
        $this->assertTrue($response->isSuccessful());
    }

    /**
     * @param array $methods
     * @return \PHPUnit_Framework_MockObject_MockObject|Job
     */
    protected function getJobMock($methods = [])
    {
        return $this->getMockBuilder('\Wirecard\Element\Job')
            ->setMethods($methods)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
 