<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

enum Status: string
{
    case  INSUFFICIENT_BALANCE = 'InsufficientBalance';
    case  INVALID_REQUEST = 'InvalidRequest';
    case  NOT_SUPPORTED = 'NotSupported';
    case  INCOMPLETE = 'Incomplete';
    case  SUBMITTED = 'Submitted';
    case  BUFFERED = 'Buffered';
    case  REJECTED = 'Rejected';
    case  SUCCESS = 'Success';
    case  FAILED = 'Failed';
    case  QUEUED = 'Queued';
    case  SENT = 'Sent';
}
