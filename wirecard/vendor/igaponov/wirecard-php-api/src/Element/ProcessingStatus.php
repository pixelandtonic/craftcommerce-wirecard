<?php

namespace Wirecard\Element;

class ProcessingStatus
{
    const STATUS_TYPE_ELIGIBLE = 'Y';

    const STATUS_TYPE_ATTEMPTED = 'A';

    const STATUS_TYPE_NOT_ENROLLED = 'N';

    const STATUS_TYPE_INELIGIBLE = 'U';

    const STATUS_TYPE_ERROR = 'E';

    const STATUS_TYPE_INFO = 'INFO';

    const RESULT_SUCCESSFUL = 'ACK';

    const RESULT_FAILED = 'NOK';

    const RESULT_PENDING = 'PENDING';

    public $guWid;

    public $authorizationCode;

    public $statusType;

    public $functionResult;

    public $timeStamp;

    /**
     * @var Error
     */
    public $error;

    public function __construct($code, $statusType, $result)
    {
        $this->authorizationCode = $code;
        $this->statusType = $statusType;
        $this->functionResult = $result;
        $this->timeStamp = new \DateTime();
    }

    public function isSuccessful()
    {
        return $this->functionResult === self::RESULT_SUCCESSFUL
        || $this->functionResult === self::RESULT_PENDING;
    }

    public function isEligible()
    {
        return $this->statusType === self::STATUS_TYPE_ELIGIBLE
        || $this->statusType === self::STATUS_TYPE_ATTEMPTED
        || $this->statusType === self::STATUS_TYPE_INFO;
    }

    public function getMessage()
    {
        return $this->error ? $this->error->message : null;
    }

    public function getCode()
    {
        return $this->error ? $this->error->number : null;
    }
}
 