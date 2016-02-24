<?php

namespace Wirecard\Element;

use Wirecard\Element\Action\BookBack;
use Wirecard\Element\Action\Capture;
use Wirecard\Element\Action\EnrollmentCheck;
use Wirecard\Element\Action\Preauthorization;
use Wirecard\Element\Action\Purchase;
use Wirecard\Element\Action\Query;
use Wirecard\Element\Action\Reversal;

class Job
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $signature;

    /**
     * @var EnrollmentCheck
     */
    public $enrollmentCheck;

    /**
     * @var Purchase
     */
    public $purchase;

    /**
     * @var BookBack
     */
    public $bookBack;

    /**
     * @var Preauthorization
     */
    public $preauthorization;

    /**
     * @var Query
     */
    public $query;

    /**
     * @var Capture
     */
    public $capture;

    /**
     * @var Reversal
     */
    public $reversal;

    /**
     * @var Error
     */
    public $error;

    public static function createEnrollmentJob($signature, EnrollmentCheck $check)
    {
        $job = new self($signature);
        $job->enrollmentCheck = $check;

        return $job;
    }

    public static function createPurchaseJob($signature, Purchase $purchase)
    {
        $job = new self($signature);
        $job->purchase = $purchase;

        return $job;
    }

    public static function createBookBackJob($signature, BookBack $bookBack)
    {
        $job = new self($signature);
        $job->bookBack = $bookBack;

        return $job;
    }

    public static function createPreauthorizationJob($signature, Preauthorization $preAuth)
    {
        $job = new self($signature);
        $job->preauthorization = $preAuth;

        return $job;
    }

    public static function createQueryJob($signature, Query $query)
    {
        $job = new self($signature);
        $job->query = $query;

        return $job;
    }

    public static function createCaptureJob($signature, Capture $capture)
    {
        $job = new self($signature);
        $job->capture = $capture;

        return $job;
    }

    public static function createReversalJob($signature, Reversal $reversal)
    {
        $job = new self($signature);
        $job->reversal = $reversal;

        return $job;
    }

    private function __construct($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @return Transaction|null
     */
    public function getTransaction()
    {
        foreach ([
            'enrollmentCheck',
            'purchase',
            'bookBack',
            'preauthorization',
            'query',
            'capture',
            'reversal'
        ] as $action) {
            if ($this->$action) {
                return $this->$action->transaction;
            }
        }

        return null;
    }
}
 