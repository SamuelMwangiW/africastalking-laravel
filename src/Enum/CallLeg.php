<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

enum CallLeg: string
{
    case CALLER = 'caller';
    case CALLEE = 'callee';
}
