<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

enum Status: string
{
    case UNSUPPORTED_PHONE_NUMBER = 'UnsupportedPhoneNumber';
    case INSUFFICIENT_BALANCE = 'InsufficientBalance';
    case PRODUCT_NOT_FOUND = 'ProductNotFound';
    case INVALID_REQUEST = 'InvalidRequest';
    case INTERNAL_ERROR = 'InternalError';
    case NOT_SUPPORTED = 'NotSupported';
    case INCOMPLETE = 'Incomplete';
    case SUBMITTED = 'Submitted';
    case PROCESSED = 'Processed';
    case BUFFERED = 'Buffered';
    case REJECTED = 'Rejected';
    case SUCCESS = 'Success';
    case FAILED = 'Failed';
    case QUEUED = 'Queued';
    case SENT = 'Sent';
}
