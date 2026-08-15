<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use SamuelMwangiW\Africastalking\Concerns\HasIdempotency;
use SamuelMwangiW\Africastalking\Saloon\Requests\Whatsapp\SendRequest;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

class Whatsapp
{
    use HasIdempotency;

    private array $body;
    private PhoneNumber $from;
    private PhoneNumber $recipient;

    public function as(string $from): Whatsapp
    {
        $this->from = PhoneNumber::make($from);

        return $this;
    }

    public function body(array $message): Whatsapp
    {
        $this->body = $message;

        return $this;
    }
    public function to(PhoneNumber|string $phoneNumber): Whatsapp
    {
        if (is_string($phoneNumber)) {
            $phoneNumber = PhoneNumber::make($phoneNumber);
        }

        $this->recipient = $phoneNumber;

        return $this;
    }

    public function send(): array
    {
        $request = SendRequest::make($this->data());

        if ($this->idempotencyKey()) {
            $request->headers()->add('Idempotency-Key', $this->idempotencyKey());
        }

        return $request->send()->throw()->dto();
    }

    protected function data(): array
    {
        return [
            'waNumber' => $this->recipient->number,
            'phoneNumber' => $this->from,
            'body' => $this->body,
        ];
    }
}
