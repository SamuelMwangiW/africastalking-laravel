<?php

namespace SamuelMwangiW\Africastalking\Concerns;

trait HasIdempotency
{
    protected ?string $idempotencyKey = null;

    public function idempotent(string $key): static
    {
        $this->idempotencyKey = $key;

        return $this;
    }

    /**
     * @return string|null
     * @internal
     */
    public function idempotencyKey(): ?string
    {
        return $this->idempotencyKey;
    }
}
