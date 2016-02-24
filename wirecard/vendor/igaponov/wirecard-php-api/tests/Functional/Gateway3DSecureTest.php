<?php

namespace Wirecard\Functional;

use DOMDocument;
use DOMElement;
use Wirecard\Element\Action\EnrollmentCheck;
use Wirecard\Element\Action\Purchase;
use Wirecard\Element\Action\Reversal;
use Wirecard\Element\Amount;
use Wirecard\Element\BillingAddress;
use Wirecard\Element\CreditCardData;
use Wirecard\Element\Job;
use Wirecard\Element\Request;
use Wirecard\Element\Response;
use Wirecard\Element\Secure;
use Wirecard\Element\Transaction;
use Wirecard\Element\TrustCenterData;
use Wirecard\Element\WireCard;

class Gateway3DSecureTestCase extends GatewayTestCase
{
    const SIGNATURE = '0000003164DF5F22';

    protected function setUp()
    {
        parent::setUp();
        $this->params['auth'] = ['00000031556BEEC6', 'TestXAPTER'];
    }

    /**
     * @large
     */
    public function testEnrollmentRequest()
    {
        $creditCard = new CreditCardData();
        $creditCard->creditCardNumber = 4012000300002001;
        $creditCard->setExpirationDate('2019-01');
        $creditCard->cardHolderName = 'John Doe';

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
        $transaction->mode = Transaction::MODE_LIVE;
        $transaction->id = '9457892347623478';
        $transaction->amount = new Amount(500);
        $transaction->currency = 'USD';
        $transaction->countryCode = 'US';
        $transaction->creditCardData = $creditCard;
        $transaction->trustCenterData = $trustCenter;

        $check = new EnrollmentCheck($transaction);
        $job = Job::createEnrollmentJob(self::SIGNATURE, $check);
        $request = new Request($job);

        /** @var WireCard $wireCard */
        $wireCard = WireCard::createWithRequest($request);

        $body = $this->serializer->serialize($wireCard, 'xml');
        $response = $this->client->send($this->createRequest($body));

        $wireCard = $this->serializer->deserialize($response->getBody(true), 'Wirecard\Element\WireCard', 'xml');

        $response = $wireCard->response;
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNotNull($response->getUrl());
        $this->assertNotNull($response->getToken());
        $this->assertNull($response->getMessage());

        return $response;
    }

    /**
     * @depends testEnrollmentRequest
     * @large
     * @param Response $response
     * @return array
     */
    public function testBankRequest(Response $response)
    {
        $data = [
            'PaReq' => $response->getToken(),
            'TermUrl' => 'https://example.com',
            'MD' => 'optional',
        ];
        $bankResponse = $this->client->createRequest('POST', $response->getUrl(), null, $data)->send();

        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->loadHTML($bankResponse->getBody(true));
        /** @var DOMElement[] $elements */
        $elements = $doc->getElementsByTagName('input');
        foreach ($elements as $element) {
            $name = $element->getAttribute('name');
            if ($name === 'PaRes') {
                return [
                    'PaRes' => $element->getAttribute('value'),
                    'GuWid' => $response->getProcessingGuWid(),
                ];
            }
        }

        $this->fail();
        return null;
    }

    /**
     * @depends testBankRequest
     * @large
     * @param array $data
     * @return string
     */
    public function testPurchaseRequest(array $data)
    {
        $secure = Secure::createResponse($data['PaRes']);

        $creditCard = new CreditCardData();
        $creditCard->secureCode = '001';

        $transaction = new Transaction();
        $transaction->id = '9457892347623478';
        $transaction->guWid = $data['GuWid'];
        $transaction->creditCardData = $creditCard;
        $transaction->secure = $secure;

        $purchase = new Purchase($transaction);
        $job = Job::createPurchaseJob(self::SIGNATURE, $purchase);
        $request = new Request($job);

        $body = $this->serializer->serialize(WireCard::createWithRequest($request), 'xml');
        $response = $this->client->send($this->createRequest($body));

        /** @var WireCard $wireCard */
        $wireCard = $this->serializer->deserialize($response->getBody(true), 'Wirecard\Element\WireCard', 'xml');

        $response = $wireCard->response;

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());

        return $response->getProcessingGuWid();
    }

    /**
     * @depends testPurchaseRequest
     * @large
     * @param string $guWid
     * @return string
     */
    public function testReversalRequest($guWid)
    {
        $transaction = new Transaction();
        $transaction->id = '9457892347623478';
        $transaction->guWid = $guWid;

        $reversal = new Reversal($transaction);
        $job = Job::createReversalJob(self::SIGNATURE, $reversal);
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
