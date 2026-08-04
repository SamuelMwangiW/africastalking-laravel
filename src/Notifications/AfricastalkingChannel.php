<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Notifications;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use ReflectionException;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\ValueObjects\Message;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageResponse;
use Throwable;

class AfricastalkingChannel
{
    /**
     * @param ReceivesSmsMessages|AnonymousNotifiable $notifiable
     * @param Notification $notification
     * @return SentMessageResponse
     * @throws AfricastalkingException
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws Throwable
     */
    public function send(ReceivesSmsMessages|AnonymousNotifiable $notifiable, Notification $notification): SentMessageResponse
    {
        if ( ! method_exists($notification, 'toAfricastalking')) {
            throw AfricastalkingException::NotificationHasNoToAfricastalking($notification::class);
        }

        $message = $notification->toAfricastalking($notifiable);

        if ($message instanceof Message) {
            return $this->assertSync($message->send());
        }

        $to = $notifiable instanceof ReceivesSmsMessages
            ? $notifiable->routeNotificationForAfricastalking($notification)
            : $notifiable->routeNotificationFor(AfricastalkingChannel::class);

        return $this->assertSync(Africastalking::sms($message)->to($to)->send());
    }

    /**
     * Notifications are always sent synchronously — {@see Message::async()}
     * is not exposed here — so the result is always a SentMessageResponse.
     *
     * @throws AfricastalkingException
     */
    private function assertSync(SentMessageResponse|PromiseInterface $response): SentMessageResponse
    {
        if ( ! $response instanceof SentMessageResponse) {
            throw AfricastalkingException::unexpectedAsyncResponse();
        }

        return $response;
    }
}
