<?php

namespace Wirecard\Element;

class ErrorTest extends \PHPUnit_Framework_TestCase
{
    public function testErrorHasTypeNumberMessageAndAdvices()
    {
        $error = new Error('REJECTED', '524', 'Cardholder not participating.');
        $this->assertSame('REJECTED', $error->type);
        $this->assertSame('524', $error->number);
        $this->assertSame('Cardholder not participating.', $error->message);
        $this->assertSame([], $error->advices);

        $error->advices = [
            'This card is eligible but not enrolled in
the 3-D Secure program.',
            'It does not require
authentication.',
        ];
        $this->assertSame('This card is eligible but not enrolled in
the 3-D Secure program. It does not require
authentication.', $error->getAdvicesAsString());
    }
}
 