<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Testing;

use Illuminate\Contracts\Container\BindingResolutionException;
use SamuelMwangiW\Africastalking\Domain\Airtime;
use SamuelMwangiW\Africastalking\Domain\VoiceCall;
use SamuelMwangiW\Africastalking\Testing\Fakes\AirtimeFake;
use SamuelMwangiW\Africastalking\Testing\Fakes\MessageFake;
use SamuelMwangiW\Africastalking\Testing\Fakes\VoiceCallFake;
use SamuelMwangiW\Africastalking\ValueObjects\Message;

enum Fakable: string
{
    case AIRTIME = Airtime::class;
    case MESSAGE = Message::class;
    case VOICE = VoiceCall::class;

    /**
     * @throws BindingResolutionException
     */
    public function fake(): void
    {
        app()->singleton(
            abstract: $this->value,
            concrete: $this->implementation()
        );
    }

    /**
     * @return class-string
     */
    private function implementation(): string
    {
        return match ($this) {
            Fakable::AIRTIME => AirtimeFake::class,
            Fakable::MESSAGE => MessageFake::class,
            Fakable::VOICE => VoiceCallFake::class,
        };
    }
}
