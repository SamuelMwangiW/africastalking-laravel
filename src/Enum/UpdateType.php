<?php

namespace SamuelMwangiW\Africastalking\Enum;

enum UpdateType: string
{
    case SUBSCRIBE = 'Addition';
    case UNSUBSCRIBE = 'Deletion';
}
