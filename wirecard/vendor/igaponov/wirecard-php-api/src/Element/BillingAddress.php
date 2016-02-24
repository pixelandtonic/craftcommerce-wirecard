<?php

namespace Wirecard\Element;

class BillingAddress
{
    public $firstName;

    public $lastName;

    public $address1;

    public $address2;

    public $city;

    public $zipCode;

    public $state;

    public $country;

    public $phone;

    public $email;

    public function __construct(
        $firstName,
        $lastName,
        $address1,
        $address2 = null,
        $city = null,
        $zipCode = null,
        $state = null,
        $country = null,
        $phone = null,
        $email = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->zipCode = $zipCode;
        $this->state = $state;
        $this->country = $country;
        $this->phone = $phone;
        $this->email = $email;
    }
}
 