<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

interface Action
{
    public function build(): string;
}
