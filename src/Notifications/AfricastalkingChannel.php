<?php

namespace SamuelMwangiW\Africastalking\Notifications;

use Illuminate\Http\Client\RequestException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\ValueObjects\Message;
use SamuelMwangiW\Africastalking\ValueObjects\RecipientsApiResponse;

class AfricastalkingChannel
{
    /**
     * @param object $notifiable
     * @param Notification $notification
     * @return Collection<int,RecipientsApiResponse>
     * @throws AfricastalkingException
     * @throws RequestException
     */
    public function send(object $notifiable, Notification $notification): Collection
    {
        $this->throwIfNotifiableDoesNotUseTrait($notifiable);
        $this->throwIfNotifiableHasNoRoute($notifiable);
        $this->throwIfNotificationHasNoToAfricastalking($notification);

        /** @phpstan-ignore-next-line */
        $message = $notification->toAfricastalking($notifiable);

        if ($message instanceof Message) {
            return $message->send();
        }

        return Africastalking::sms($message)
            /** @phpstan-ignore-next-line */
            ->to($notifiable->routeNotificationForAfricastalking($notification))
            ->send();
    }

    /**
     * @throws AfricastalkingException
     */
    private function throwIfNotifiableDoesNotUseTrait(object $notifiable): void
    {
        $traits = collect(class_uses_recursive($notifiable::class));

        if ($traits->doesntContain(Notifiable::class)) {
            throw AfricastalkingException::objectNotNotifiable($notifiable::class);
        }
    }

    /**
     * @throws AfricastalkingException
     */
    private function throwIfNotifiableHasNoRoute(object $notifiable): void
    {
        if (! $notifiable instanceof ReceivesSmsMessages) {
            throw AfricastalkingException::NotifiableDoesNotImplementReceivesSmsMessages($notifiable::class);
        }
    }

    /**
     * @throws AfricastalkingException
     */
    private function throwIfNotificationHasNoToAfricastalking(Notification $notification): void
    {
        if (! method_exists($notification, 'toAfricastalking')) {
            throw AfricastalkingException::NotificationHasNoToAfricastalking($notification::class);
        }
    }
}
