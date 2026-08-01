<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Exceptions;

use Exception;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\SynthesisedSpeech;

class AfricastalkingException extends Exception
{
    /**
     * @param class-string $class
     * @return AfricastalkingException
     */
    public static function NotificationHasNoToAfricastalking(string $class): AfricastalkingException
    {
        return new AfricastalkingException(
            message: "Notification object {$class} has no toAfricastalking()",
        );
    }

    /**
     * @param string $message
     * @return AfricastalkingException
     */
    public static function messageSendingFailed(string $message): AfricastalkingException
    {
        return new AfricastalkingException(
            message: $message,
        );
    }

    /**
     * @param string $currencyCode
     * @return AfricastalkingException
     */
    public static function invalidCurrencyCode(string $currencyCode): AfricastalkingException
    {
        return new AfricastalkingException(
            message: "The currency {$currencyCode} is not supported at the moment",
        );
    }

    /**
     * @param int|float $amount
     * @return AfricastalkingException
     */
    public static function minimumAmount(int|float $amount): AfricastalkingException
    {
        return new AfricastalkingException(
            message: "The amount entered {$amount} is below the minimum supported",
        );
    }

    public static function notSynthesisedSpeech(): AfricastalkingException
    {
        return new AfricastalkingException(
            message: 'The returned object must be an instance of '.SynthesisedSpeech::class,
        );
    }

    /**
     * @param class-string $expectedClass
     */
    public static function invalidPoolItem(string $expectedClass, mixed $item): AfricastalkingException
    {
        $type = is_object($item) ? $item::class : gettype($item);

        return new AfricastalkingException(
            message: "Every item passed to pool() must be an instance of {$expectedClass}, {$type} given",
        );
    }

    public static function mixedSmsPoolModes(): AfricastalkingException
    {
        return new AfricastalkingException(
            message: 'A single pool() cannot mix bulk and premium SMS messages, since they resolve to different API endpoints',
        );
    }
}
