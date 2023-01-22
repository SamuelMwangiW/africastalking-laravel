<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

enum FailureReason: string
{
    case INSUFFICIENT_CREDIT = 'InsufficientCredit';
    case INVALID_LINK_ID = 'InvalidLinkId';
    case USER_IS_INACTIVE = 'UserIsInactive';
    case USER_IN_BLACK_LIST = 'UserInBlackList';
    case USER_ACCOUNT_SUSPENDED = 'UserAccountSuspended';
    case NOT_NETWORK_SUBSCRIBER = 'NotNetworkSubscriber';
    case USER_NOT_SUBSCRIBED_TO_PRODUCT = 'UserNotSubscribedToProduct';
    case USER_DOES_NOT_EXIST = 'UserDoesNotExist';
    case DELIVERY_FAILURE = 'DeliveryFailure';
}
