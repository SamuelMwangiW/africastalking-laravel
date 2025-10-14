<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use SamuelMwangiW\Africastalking\Saloon\Requests\Voice\QueueStatusRequest;

class QueueStatus
{
    public ?array $phoneNumbers;

    public function for(string|array|null $phoneNumbers): static
    {
        if (is_string($phoneNumbers)) {
            $phoneNumbers = [$phoneNumbers];
        }

        $this->phoneNumbers = $phoneNumbers;

        return $this;
    }

    public function get(): mixed
    {
        return $this->send();
    }

    public function send(): mixed
    {
        $request = QueueStatusRequest::make($this->data());

        return $request->send()->throw()->dto();
    }

    public function data(): array
    {
        return [
            'phoneNumbers' => implode(',', $this->phoneNumbers()),
        ];
    }

    private function phoneNumbers(): array
    {
        return $this->phoneNumbers ?? [config('africastalking.voice.from')];
    }
}
