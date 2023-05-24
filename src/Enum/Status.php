<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

enum Status: string
{
    case  INSUFFICIENT_BALANCE = 'InsufficientBalance';
    case  INCOMPLETE = 'Incomplete';
    case  SUBMITTED = 'Submitted';
    case  BUFFERED = 'Buffered';
    case  REJECTED = 'Rejected';
    case  SUCCESS = 'Success';
    case  FAILED = 'Failed';
    case  SENT = 'Sent';
}
