<?php
namespace Commerce\Gateways\Omnipay;

use Commerce\Gateways\BaseGatewayAdapter;

class Wirecard_GatewayAdapter extends BaseGatewayAdapter
{
    public function handle()
    {
        return "Wirecard";
    }

    public function requiresCreditCard()
    {
        return false;
    }
}
