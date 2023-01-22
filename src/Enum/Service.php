<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

use Exception;

enum Service
{
    case AIRTIME;
    case APPLICATION;
    case BULK_SMS;
    case CONTENT;
    case DATA;
    case PAYMENT;
    case VOICE;
    case WEBRTC;

    public function liveBaseUrl(): string
    {
        return match ($this) {
            self::AIRTIME,
            self::APPLICATION,
            self::BULK_SMS => 'https://api.africastalking.com/version1/',
            self::CONTENT => 'https://content.africastalking.com/version1/',
            self::DATA,
            self::PAYMENT => 'https://payments.africastalking.com/',
            self::VOICE => 'https://voice.africastalking.com/',
            self::WEBRTC => 'https://webrtc.africastalking.com',
        };
    }

    /**
     * @throws Exception
     */
    public function sandboxBaseUrl(): string
    {
        return match ($this) {
            self::AIRTIME,
            self::APPLICATION,
            self::BULK_SMS,
            self::CONTENT => 'https://api.sandbox.africastalking.com/version1/',
            self::PAYMENT => 'https://payments.sandbox.africastalking.com/',
            self::VOICE => 'https://voice.sandbox.africastalking.com/',
            self::DATA => throw new Exception('Mobile data is not supported on Sandbox'),
            self::WEBRTC => throw new Exception('WebRTC not supported on Sandbox environment'),
        };
    }
}
