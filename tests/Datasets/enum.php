<?php

dataset('failure-reason-values', [
    'InsufficientCredit',
    'InvalidLinkId',
    'UserIsInactive',
    'UserInBlackList',
    'UserAccountSuspended',
    'NotNetworkSubscriber',
    'UserNotSubscribedToProduct',
    'UserDoesNotExist',
    'DeliveryFailure',
]);

dataset('network-codes', [
    62006,
    62002,
//    62001,
//    62120,
//    62130,
//    62150,
//    62160,
//    63510,
//    63513,
//    63514,
//    63601,
//    63902,
//    63903,
//    63907,
//    63999,
//    64002,
//    64003,
//    64004,
//    64005,
//    64007,
//    64009,
//    64101,
//    64110,
//    64111,
//    64114,
//    64501,
//    64502,
//    65001,
//    65010,
//    65501,
//    65502,
//    65507,
//    65510,
    99999,
]);

dataset('status-values', [
//    'Incomplete',
//    'Submitted',
//    'Buffered',
    'Rejected',
    'Success',
    'Failed',
    'Sent',
]);

dataset('hangup-causes', [
    'NORMAL_CLEARING',
    'CALL_REJECTED',
    'NORMAL_TEMPORARY_FAILURE',
    'RECOVERY_ON_TIMER_EXPIRE',
    'ORIGINATOR_CANCEL',
    'LOSE_RACE',
    'USER_BUSY',
    'NO_ANSWER',
    'NO_USER_RESPONSE',
    'SUBSCRIBER_ABSENT',
    'SERVICE_UNAVAILABLE',
    'USER_NOT_REGISTERED',
    'UNALLOCATED_NUMBER',
    'UNSPECIFIED',
]);

dataset('call-directions', ['Inbound', 'Outbound']);

dataset('currencies', [
    'KES',
    'UGX',
    'TZS',
    'NGN',
//    'MWK',
//    'ZMK',
//    'ZAR',
//    'XOF',
//    'GHS',
//    'RWF',
//    'ETB',
//    'USD',
]);

dataset('update-types', [
    'Addition',
    'Deletion',
]);

dataset('payment-providers', [
    'Mpesa',
    'TigoTanzania',
    'Athena',
]);
