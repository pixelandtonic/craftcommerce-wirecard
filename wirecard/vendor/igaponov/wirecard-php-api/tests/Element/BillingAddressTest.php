<?php

namespace Wirecard\Element;

class BillingAddressTest extends \PHPUnit_Framework_TestCase
{
    public $firstName;

    public $lastName;

    public $address;

    public $city;

    public $zipCode;

    public $state;

    public $country;

    public function testBillingAddressHasAddressEmailAndPhone()
    {
        $billingAddress = new BillingAddress(
            'John',
            'Doe',
            '550 South Winchester blvd.',
            'empty',
            'San Jose',
            95128,
            'CA',
            'US',
            '+1(202)555-1234',
            'John.Doe@email.com'
        );
        $this->assertSame('John', $billingAddress->firstName);
        $this->assertSame('Doe', $billingAddress->lastName);
        $this->assertSame('550 South Winchester blvd.', $billingAddress->address1);
        $this->assertSame('empty', $billingAddress->address2);
        $this->assertSame('San Jose', $billingAddress->city);
        $this->assertSame(95128, $billingAddress->zipCode);
        $this->assertSame('CA', $billingAddress->state);
        $this->assertSame('US', $billingAddress->country);
        $this->assertSame('+1(202)555-1234', $billingAddress->phone);
        $this->assertSame('John.Doe@email.com', $billingAddress->email);
    }
}
