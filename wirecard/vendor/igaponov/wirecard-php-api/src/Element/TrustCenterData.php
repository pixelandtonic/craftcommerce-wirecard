<?php

namespace Wirecard\Element;

class TrustCenterData 
{
    /**
     * @var BillingAddress
     */
    public $billingAddress;

    public function __construct(BillingAddress $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }
}
 