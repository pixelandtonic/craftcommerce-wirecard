<?php

namespace Wirecard\Element;

class ContactData
{
    public $ipAddress;

    public $deviceIdentification;

    public function __construct($ipAddress = null, $deviceIdentification = null)
    {
        $this->ipAddress = $ipAddress;
        $this->deviceIdentification = $deviceIdentification;
    }
}
