<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Notifications;

use Illuminate\Http\Client\RequestException;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\ValueObjects\Message;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageResponse;

class AfricastalkingChannel
{
    /**
     * @param object $notifiable
     * @param Notification $notification
     * @return SentMessageResponse
     * @throws AfricastalkingException
     * @throws RequestException
     */
    public function send(object $notifiable, Notification $notification): SentMessageResponse
    {
        $this->throwIfNotifiableDoesNotUseTrait($notifiable);
        $this->throwIfNotificationHasNoToAfricastalking($notification);

        /** @phpstan-ignore-next-line */
        $message = $notification->toAfricastalking($notifiable);

        if ($message instanceof Message) {
            return $message->send();
        }

        return Africastalking::sms($message)
            ->to($this->recipient($notifiable, $notification))
            ->send();
    }

    /**
     * @throws AfricastalkingException
     */
    private function throwIfNotifiableDoesNotUseTrait(object $notifiable): void
    {
        if ($notifiable instanceof AnonymousNotifiable) {
            return;
        }

        $traits = collect(class_uses_recursive($notifiable::class));

        if ($traits->doesntContain(Notifiable::class)) {
            throw AfricastalkingException::objectNotNotifiable($notifiable::class);
        }
    }

    /**
     * @throws AfricastalkingException
     */
    private function throwIfNotificationHasNoToAfricastalking(Notification $notification): void
    {
        if ( ! method_exists($notification, 'toAfricastalking')) {
            throw AfricastalkingException::NotificationHasNoToAfricastalking($notification::class);
        }
    }

    /**
     * @throws AfricastalkingException
     */
    private function recipient(object $notifiable, Notification $notification): string
    {
        if ($notifiable instanceof ReceivesSmsMessages) {
            return $notifiable->routeNotificationForAfricastalking($notification);
        }

        if ($notifiable instanceof AnonymousNotifiable) {
            return $notifiable->routeNotificationFor(AfricastalkingChannel::class);
        }

        throw AfricastalkingException::NotifiableDoesNotImplementReceivesSmsMessages($notifiable::class);
    }
}
