<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class MessageDTO implements DTOContract
{
    public int $bulkSMSMode = 1;
    public int $enqueue = 1;
    public string|null $keyword = null;
    public string|null $linkId = null;
    public int|null $retryDurationInHours = null;

    /**
     * @param string $message
     * @param Collection<int,PhoneNumberDTO> $to
     * @param string|null $from
     */
    public function __construct(
        public string      $message,
        public Collection  $to,
        public string|null $from = null,
    )
    {
    }

    public function enqueue(bool $value = true): static
    {
        $this->enqueue = $value ? 1 : 0;

        return $this;
    }

    public function bulk(bool $value = true): static
    {
        $this->bulkSMSMode = $value ? 1 : 0;

        return $this;
    }

    public function keyword(string|null $value): static
    {
        $this->keyword = $value;

        return $this;
    }

    public function linkId(string|null $value): static
    {
        $this->linkId = $value;

        return $this;
    }

    public function retry(int $value): static
    {
        $this->retryDurationInHours = $value;

        return $this;
    }

    public function send(): void
    {

    }

    public function __toString(): string
    {
        return strval(json_encode($this));
    }

    public function __toArray(): array
    {
        return [
            'bulkSMSMode' => $this->bulkSMSMode,
            'enqueue' => $this->enqueue,
            'keyword' => $this->keyword,
            'linkId' => $this->linkId,
            'retryDurationInHours' => $this->retryDurationInHours,
            'message' => $this->message,
            'to' => $this->to->toArray(),
            'from' => $this->from,
        ];
    }
}
