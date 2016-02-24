<?php

namespace Wirecard\Element;

class ActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider functionProvider()
     * @param string $class
     */
    public function testFunctionHasTransaction($class)
    {
        $transaction = $this->getMockBuilder('\Wirecard\Element\Transaction')
            ->disableOriginalConstructor()
            ->getMock();

        $function = new $class($transaction);
        $this->assertInstanceOf('\Wirecard\Element\Transaction', $function->transaction);
    }

    public function functionProvider()
    {
        return [
            ['\Wirecard\Element\Action\EnrollmentCheck'],
            ['\Wirecard\Element\Action\Purchase'],
            ['\Wirecard\Element\Action\BookBack'],
            ['\Wirecard\Element\Action\Query'],
            ['\Wirecard\Element\Action\Preauthorization'],
            ['\Wirecard\Element\Action\Capture'],
            ['\Wirecard\Element\Action\Reversal'],
        ];
    }
}
 