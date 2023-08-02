<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

enum BundlesValidity: string
{
    case DAILY = 'Day';
    case WEEKLY = 'Week';
    case BI_WEEKLY = 'BiWeekly';
    case MONTHLY = 'Month';
    case QUARTERLY = 'Quarterly';
}
