<?php

namespace Wirecard\Functional;

use Wirecard\Element\Action\BookBack;
use Wirecard\Element\Action\Capture;
use Wirecard\Element\Action\Preauthorization;
use Wirecard\Element\Action\Query;
use Wirecard\Element\Amount;
use Wirecard\Element\BillingAddress;
use Wirecard\Element\CreditCardData;
use Wirecard\Element\Job;
use Wirecard\Element\Request;
use Wirecard\Element\Transaction;
use Wirecard\Element\TrustCenterData;
use Wirecard\Element\WireCard;

class GatewayTest extends GatewayTestCase
{
    const SIGNATURE = '56501';

    protected function setUp()
    {
        parent::setUp();
        $this->params['auth'] = ['56501', 'TestXAPTER'];
    }

    /**
     * @large
     */
    public function testPreauthorizationRequest()
    {
        $creditCard = new CreditCardData();
        $creditCard->creditCardNumber = 4200000000000000;
        $creditCard->setExpirationDate('2019-01');
        $creditCard->cardHolderName = 'John Doe';
        $creditCard->secureCode = 471;

        $address = new BillingAddress(
            'John',
            'Doe',
            '550 South Winchester blvd.',
            'P.O. Box 850',
            'San Jose',
            '95128',
            'CA',
            'US',
            '+1(202)555-1234',
            'John.Doe@email.com'
        );
        $trustCenter = new TrustCenterData($address);

        $transaction = new Transaction();
        $transaction->mode = Transaction::MODE_DEMO;
        $transaction->id = '9457892347623478';
        $transaction->amount = new Amount(500);
        $transaction->currency = 'USD';
        $transaction->countryCode = 'US';
        $transaction->creditCardData = $creditCard;
        $transaction->trustCenterData = $trustCenter;

        $preauthorization = new Preauthorization($transaction);
        $job = Job::createPreauthorizationJob(self::SIGNATURE, $preauthorization);
        $request = new Request($job);

        /** @var WireCard $wireCard */
        $wireCard = WireCard::createWithRequest($request);

        $body = $this->serializer->serialize($wireCard, 'xml');
        $response = $this->client->send($this->createRequest($body));

        $wireCard = $this->serializer->deserialize($response->getBody(true), 'Wirecard\Element\WireCard', 'xml');

        $response = $wireCard->response;
        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getMessage());

        return $response->getProcessingGuWid();
    }

    /**
     * @depends testPreauthorizationRequest
     * @large
     * @param string $guWid
     * @return string
     */
    public function testCaptureRequest($guWid)
    {
        $transaction = new Transaction();
        $transaction->id = '9457892347623478';
        $transaction->guWid = $guWid;

        $capture = new Capture($transaction);
        $job = Job::createCaptureJob(self::SIGNATURE, $capture);
        $request = new Request($job);

        $body = $this->serializer->serialize(WireCard::createWithRequest($request), 'xml');
        $response = $this->client->send($this->createRequest($body));

        /** @var WireCard $wireCard */
        $wireCard = $this->serializer->deserialize($response->getBody(true), 'Wirecard\Element\WireCard', 'xml');

        $response = $wireCard->response;

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());

        return $wireCard->response->getProcessingGuWid();
    }

    /**
     * @depends testCaptureRequest
     * @large
     * @param string $guWid
     * @return string
     */
    public function testQueryRequest($guWid)
    {
        $transaction = new Transaction();
        $transaction->id = '9457892347623478';
        $transaction->guWid = $guWid;

        $query = new Query($transaction);
        $job = Job::createQueryJob(self::SIGNATURE, $query);
        $request = new Request($job);

        $body = $this->serializer->serialize(WireCard::createWithRequest($request), 'xml');
        $response = $this->client->send($this->createRequest($body));

        /** @var WireCard $wireCard */
        $wireCard = $this->serializer->deserialize($response->getBody(true), 'Wirecard\Element\WireCard', 'xml');

        $response = $wireCard->response;

        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getMessage());
    }

    /**
     * @depends testCaptureRequest
     * @large
     * @param string $guWid
     * @return string
     */
    public function testBookBackRequest($guWid)
    {
        $transaction = new Transaction();
        $transaction->id = '9457892347623478';
        $transaction->guWid = $guWid;
        $transaction->amount = new Amount(500);

        $bookBack = new BookBack($transaction);
        $job = Job::createBookBackJob(self::SIGNATURE, $bookBack);
        $request = new Request($job);

        $body = $this->serializer->serialize(WireCard::createWithRequest($request), 'xml');
        $response = $this->client->send($this->createRequest($body));

        /** @var WireCard $wireCard */
        $wireCard = $this->serializer->deserialize($response->getBody(true), 'Wirecard\Element\WireCard', 'xml');

        $response = $wireCard->response;

        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getMessage());
    }
}
