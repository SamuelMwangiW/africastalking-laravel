<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Response;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Routing\ResponseFactory;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Dequeue;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Dial;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Enqueue;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\GetDigits;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Play;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Record;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Redirect;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Reject;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Say;
use Symfony\Component\HttpFoundation\Response;

class VoiceResponse implements Responsable
{
    private string $response;

    public function __construct()
    {
        $this->response = '';
    }

    /**
     * @throws AfricastalkingException
     */
    public function say(string|callable $message, bool $playBeep = false, ?string $voice = null): static
    {
        $this->response .= Say::make($message, $playBeep, $voice)->build();

        return $this;
    }

    public function play(string $url): static
    {
        $this->response .= Play::make($url)->build();

        return $this;
    }

    public function getDigits(
        string      $say,
        ?string $finishOnKey = null,
        ?int    $timeout = null,
        ?int    $numDigits = null,
        ?string $callbackUrl = null,
    ): static {
        $this->response .= GetDigits::make(
            say: $say,
            finishOnKey: $finishOnKey,
            timeout: $timeout,
            numDigits: $numDigits,
            callbackUrl: $callbackUrl,
        )->build();

        return $this;
    }

    public function record(
        string      $say,
        ?string $finishOnKey = null,
        ?int    $timeout = null,
        ?int    $maxLength = null,
        bool        $playBeep = false,
        bool        $trimSilence = false,
        ?string $callbackUrl = null,
    ): static {
        $this->response .= Record::make(
            say: $say,
            finishOnKey: $finishOnKey,
            timeout: $timeout,
            maxLength: $maxLength,
            playBeep: $playBeep,
            trimSilence: $trimSilence,
            callbackUrl: $callbackUrl,
        )->build();

        return $this;
    }

    public function dial(
        array       $phoneNumbers,
        bool        $record = false,
        ?string $ringBackTone = null,
        int         $maxDuration = 0,
        bool        $sequential = false,
        ?string $callerId = null,
    ): static {
        $this->response .= Dial::make(
            phoneNumbers: $phoneNumbers,
            record: $record,
            ringBackTone: $ringBackTone,
            maxDuration: $maxDuration,
            sequential: $sequential,
            callerId: $callerId,
        )->build();

        return $this;
    }

    public function redirect(string $url): static
    {
        $this->response .= Redirect::make(url: $url)->build();

        return $this;
    }

    public function dequeue(string $name, ?string $phoneNumber = null): static
    {
        $this->response .= Dequeue::make(name: $name, phoneNumber: $phoneNumber)->build();

        return $this;
    }

    public function queue(string $name, ?string $holdMusic = null): static
    {
        $this->response .= Enqueue::make(name: $name, holdMusic: $holdMusic)->build();

        return $this;
    }

    public function reject(): static
    {
        $this->response .= Reject::make()->build();

        return $this;
    }

    public function toResponse($request): Response
    {
        /** @var ResponseFactory $response */
        $response = app(ResponseFactory::class);

        return $response->make(
            content: $this->getResponse(),
            status: Response::HTTP_OK,
            headers: ['Content-Type' => 'application/xml'],
        );
    }

    public function getResponse(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?><Response>'.$this->response.'</Response>';
    }
}
