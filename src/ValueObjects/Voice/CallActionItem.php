<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

interface CallActionItem
{
    public function buildJson(): array;
}
