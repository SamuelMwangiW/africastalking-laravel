<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Concerns;

trait HasIdempotency
{
    public string|null $idempotencyKey = null;

    public function idempotent(string $key): static
    {
        $this->idempotencyKey = $key;

        return $this;
    }
}
