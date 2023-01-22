<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

enum UpdateType: string
{
    case SUBSCRIBE = 'Addition';
    case UNSUBSCRIBE = 'Deletion';
}
