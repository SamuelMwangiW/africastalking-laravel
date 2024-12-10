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
    case INSIGHTS;
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
            self::DATA => 'https://bundles.africastalking.com/',
            self::INSIGHTS => 'https://insights.africastalking.com/v1',
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
            self::DATA => 'https://bundles.sandbox.africastalking.com/',
            self::INSIGHTS => 'https://insights.sandbox.africastalking.com/v1',
            self::WEBRTC => throw new Exception('WebRTC not supported on Sandbox environment'),
        };
    }
}
