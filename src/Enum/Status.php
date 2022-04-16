<?php

namespace SamuelMwangiW\Africastalking\Enum;

enum Status: string
{
    case  INCOMPLETE = 'Incomplete';
    case  SUBMITTED = 'Submitted';
    case  BUFFERED = 'Buffered';
    case  REJECTED = 'Rejected';
    case  SUCCESS = 'Success';
    case  FAILED = 'Failed';
    case  SENT = 'Sent';
}
