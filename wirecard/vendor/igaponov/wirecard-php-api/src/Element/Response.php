<?php

namespace Wirecard\Element;

class Response
{
    /**
     * @var Job
     */
    public $job;

    /**
     * @var Error
     */
    public $error;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function isSuccessful()
    {
        if ($this->error === null && $this->job->error === null) {
            $transaction = $this->getTransaction();

            return $transaction ? $transaction->isSuccessful() : false;
        }

        return false;
    }

    public function isRedirect()
    {
        $transaction = $this->getTransaction();
        return $transaction ? $transaction->isRedirect() : false;
    }

    public function getUrl()
    {
        $transaction = $this->getTransaction();
        return $transaction ? $transaction->getUrl() : null;
    }

    public function getToken()
    {
        $transaction = $this->getTransaction();
        return $transaction ? $transaction->getToken() : null;
    }

    public function getMessage()
    {
        $transaction = $this->getTransaction();
        return $transaction ? $transaction->getMessage() : null;
    }

    public function getCode()
    {
        $transaction = $this->getTransaction();
        return $transaction ? $transaction->getCode() : null;
    }

    public function getProcessingGuWid()
    {
        $transaction = $this->getTransaction();
        return $transaction ? $transaction->getProcessingGuWid() : null;
    }

    protected function getTransaction()
    {
        return $this->job ? $this->job->getTransaction() : null;
    }
}
 