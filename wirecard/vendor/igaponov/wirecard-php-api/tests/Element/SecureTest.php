<?php

namespace Wirecard\Element;

class SecureTest extends \PHPUnit_Framework_TestCase
{
    public function testSecureHasMessageAndUrl()
    {
        $secure = Secure::createRequest('eJxVUuFygjAMfhXPw9IWh', 'https://acs—ap.3dsecure.net/shopping');
        $this->assertSame('eJxVUuFygjAMfhXPw9IWh', $secure->request);
        $this->assertSame('https://acs—ap.3dsecure.net/shopping', $secure->url);

        $secure = Secure::createResponse('eJxVUuFygjAMfhXPw9IWh', 'https://acs—ap.3dsecure.net/shopping');
        $this->assertSame('eJxVUuFygjAMfhXPw9IWh', $secure->response);
        $this->assertSame('https://acs—ap.3dsecure.net/shopping', $secure->url);
    }
}
 