<?php

namespace Wirecard\Functional;

use Wirecard\Element\Amount;
use Wirecard\Element\BillingAddress;
use Wirecard\Element\ContactData;
use Wirecard\Element\CreditCardData;
use Wirecard\Element\Error;
use Wirecard\Element\ProcessingStatus;
use Wirecard\Element\RecurringTransaction;
use Wirecard\Element\Request;
use Wirecard\Element\Job;
use Wirecard\Element\Response;
use Wirecard\Element\Transaction;
use Wirecard\Element\TrustCenterData;
use Wirecard\Element\WireCard;

class SerializationTest extends FunctionalTestCase
{
    /**
     * @dataProvider actionProvider
     */
    public function testSerializeRequest($class, $method, $func)
    {
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

        $trust = new TrustCenterData($address);

        $card = new CreditCardData();
        $card->creditCardNumber = '4200000000000000';
        $card->setExpirationDate('2005-01-01');
        $card->cardHolderName = 'John Doe';
        $card->secureCode = '123';

        $contactData = new ContactData('192.168.1.1', 'f-q04u9f');

        $recurringTransaction = new RecurringTransaction(RecurringTransaction::TYPE_INITIAL);

        $transaction = new Transaction();
        $transaction->mode = Transaction::MODE_DEMO;
        $transaction->id = '9457892347623478';
        $transaction->guWid = 'C328668112556109425394';
        $transaction->commerceType = 'MOTO';
        $transaction->referenceId = 'FJQ845GFW4I7FGQ348FQ349Q34';
        $transaction->startTime = new \DateTime('2005-12-12');
        $transaction->endTime = new \DateTime('2005-12-13');
        $transaction->paymentGroupId = '5FW9ERYG';
        $transaction->salesDate = new \DateTime('2005-12-11');
        $transaction->authorizationCode = 92381;
        $transaction->amount = new Amount(5);
        $transaction->currency = 'EUR';
        $transaction->countryCode = 'DE';
        $transaction->usage = 'OrderNo-FT345S71 Thank you';
        $transaction->creditCardData = $card;
        $transaction->trustCenterData = $trust;
        $transaction->contactData = $contactData;
        $transaction->recurringTransaction = $recurringTransaction;

        $action = new $class($transaction);
        $action->id = 'authentication 1';
        $job = call_user_func_array(['\Wirecard\Element\Job', $method], ['0123456789ABCDEF', $action]);
        $job->id = 'job 1';

        $request = new Request($job);
        $request = WireCard::createWithRequest($request);
        $xml = $this->serializer->serialize($request, 'xml');
        $xmlString = file_get_contents(__DIR__ . "/data/Request.xml");
        $xmlString = str_replace('FNC_CC_', 'FNC_CC_' . $func, $xmlString);
        $this->assertXmlStringEqualsXmlString($xmlString, $xml);
    }

    /**
     * @dataProvider actionProvider
     */
    public function testDeserializeResponse($class, $method, $func)
    {
        $error = new Error(
            'DATA_ERROR',
            '24998',
            'Demo-card or demo-mode transactions are not allowed without demo terminal mode.'
        );
        $error->advices = [
            "Inspect your card number or remove attribute mode=''demo'' of tag 'CC_TRANSACTION'"
        ];

        $processing = new ProcessingStatus('8WERH84', 'INFO', 'NOK');
        $processing->guWid = 'C895978124540997772104';
        $processing->timeStamp = new \DateTime('2009-06-19 13:12:57', new \DateTimeZone('UTC'));
        $processing->error = $error;

        $transaction = new Transaction();
        $transaction->mode = Transaction::MODE_DEMO;
        $transaction->id = '9457892347623478';
        $transaction->processingStatus = $processing;

        $action = new $class($transaction);
        $action->id = 'authentication 1';
        $job = call_user_func_array(['\Wirecard\Element\Job', $method], ['0123456789ABCDEF', $action]);
        $job->id = 'job 1';

        $response = new Response($job);
        $wirecard = WireCard::createWithResponse($response);
        $xmlString = file_get_contents(__DIR__ . "/data/Response.xml");
        $xmlString = str_replace('FNC_CC_', 'FNC_CC_' . $func, $xmlString);
        $wirecardExpected = $this->serializer->deserialize($xmlString, 'Wirecard\Element\WireCard', 'xml');
        $this->assertEquals($wirecardExpected, $wirecard);
    }

    public function actionProvider()
    {
        return [
            ['Wirecard\Element\Action\EnrollmentCheck', 'createEnrollmentJob', 'ENROLLMENT_CHECK'],
            ['Wirecard\Element\Action\Purchase', 'createPurchaseJob', 'PURCHASE'],
            ['Wirecard\Element\Action\BookBack', 'createBookBackJob', 'BOOKBACK'],
            ['Wirecard\Element\Action\Query', 'createQueryJob', 'QUERY'],
            ['Wirecard\Element\Action\Preauthorization', 'createPreauthorizationJob', 'PREAUTHORIZATION'],
            ['Wirecard\Element\Action\Capture', 'createCaptureJob', 'CAPTURE'],
            ['Wirecard\Element\Action\Reversal', 'createReversalJob', 'REVERSAL'],
        ];
    }
}
 