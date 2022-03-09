<?php

namespace SamuelMwangiW\Africastalking\Traits;

trait HasIdempotency
{
    public string|null $idempotencyKey = null;

    public function idempotent(string $key): static
    {
        $this->idempotencyKey = $key;

        return $this;
    }
}
