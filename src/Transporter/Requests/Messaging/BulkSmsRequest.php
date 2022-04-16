<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Messaging;

use SamuelMwangiW\Africastalking\Transporter\Requests\AfricastalkingRequest;

class BulkSmsRequest extends AfricastalkingRequest
{
    protected string $path = 'messaging';
}
