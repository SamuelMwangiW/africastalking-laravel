<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Notifications;

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
            return $message->send();
        }

        return Africastalking::sms($message)
            ->to($this->recipient($notifiable, $notification))
            ->send();
    }

    private function recipient(ReceivesSmsMessages|AnonymousNotifiable $notifiable, Notification $notification): string
    {
        if ($notifiable instanceof ReceivesSmsMessages) {
            return $notifiable->routeNotificationForAfricastalking($notification);
        }

        return $notifiable->routeNotificationFor(AfricastalkingChannel::class);
    }
}
