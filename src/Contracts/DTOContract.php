<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Contracts;

interface DTOContract
{
    public function __toString(): string;

    public function __toArray(): array;
}
