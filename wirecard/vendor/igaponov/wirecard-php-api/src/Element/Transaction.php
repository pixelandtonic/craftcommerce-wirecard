<?php

namespace Wirecard\Element;

class Transaction
{
    const MODE_DEMO = 'demo';

    const MODE_LIVE = 'live';

    const TYPE_COMMERCE = 'eCommerce';

    const TYPE_MOTO = 'MOTO';

    const TYPE_PRESENT = 'CardPresent';

    public $mode = self::MODE_LIVE;

    public $id;

    public $commerceType;

    public $referenceId;

    public $startTime;

    public $endTime;

    public $paymentGroupId;

    public $guWid;

    public $salesDate;

    public $authorizationCode;

    public $amount;

    public $currency;

    public $countryCode;

    public $usage;

    /**
     * @var RecurringTransaction
     */
    public $recurringTransaction;

    /**
     * @var CreditCardData
     */
    public $creditCardData;

    /**
     * @var ContactData
     */
    public $contactData;

    /**
     * @var TrustCenterData
     */
    public $trustCenterData;

    /**
     * @var ProcessingStatus
     */
    public $processingStatus;

    /**
     * @var Secure
     */
    public $secure;

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        if ($this->processingStatus) {
            return $this->processingStatus->isSuccessful()
            && $this->processingStatus->isEligible();
        }

        return false;
    }

    public function isRedirect()
    {
        return $this->secure !== null;
    }

    public function getUrl()
    {
        return $this->secure ? $this->secure->url : null;
    }

    public function getToken()
    {
        return $this->secure ? $this->secure->request : null;
    }

    public function getMessage()
    {
        return $this->processingStatus ? $this->processingStatus->getMessage() : null;
    }

    public function getCode()
    {
        return $this->processingStatus ? $this->processingStatus->getCode() : null;
    }

    public function getProcessingGuWid()
    {
        return $this->processingStatus ? $this->processingStatus->guWid : null;
    }
}
