<?php

namespace SamuelMwangiW\Africastalking\Exceptions;

use Illuminate\Notifications\Notifiable;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;

class AfricastalkingException extends \Exception
{
    /**
     * @param class-string $class
     * @return AfricastalkingException
     */
    public static function objectNotNotifiable(string $class): AfricastalkingException
    {
        return new AfricastalkingException(
            message: "The class {$class} should use ".Notifiable::class." trait"
        );
    }

    /**
     * @param class-string $class
     * @return AfricastalkingException
     */
    public static function NotifiableDoesNotImplementReceivesSmsMessages(string $class): AfricastalkingException
    {
        return new AfricastalkingException(
            message: "Notifiable class {$class} does not implement ".ReceivesSmsMessages::class." contract"
        );
    }

    /**
     * @param class-string $class
     * @return AfricastalkingException
     */
    public static function NotificationHasNoToAfricastalking(string $class): AfricastalkingException
    {
        return new AfricastalkingException(
            message: "Notification object {$class} has no toAfricastalking()"
        );
    }

    /**
     * @param string $message
     * @return AfricastalkingException
     */
    public static function messageSendingFailed(string $message): AfricastalkingException
    {
        return new AfricastalkingException(
            message: $message
        );
    }

    /**
     * @param string $currencyCode
     * @return AfricastalkingException
     */
    public static function invalidCurrencyCode(string $currencyCode): AfricastalkingException
    {
        return new AfricastalkingException(
            message: "The currency {$currencyCode} is not supported at the moment"
        );
    }
}
