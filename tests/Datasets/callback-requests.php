<?php

use function Pest\Faker\faker;

dataset('airtime-status-notification', [
    [
        [
            'requestId' => 'ATXid_520e732ea1191c1f03a7d9bea3a91006',
            'phoneNumber' => '+254720123123',
            'description' => 'Airtime Delivered Successfully',
            'value' => 'KES 100.0000',
            'discount' => 'KES 0.6000',
        ],
    ],
]);

dataset('airtime-validation-notification', [
    [
        [
            'transactionId' => 'ATXid_520e732ea1191c1f03a7d9bea3a91006',
            'phoneNumber' => '+254720123123',
            'sourceIpAddress' => '127.12.32.24',
            'currencyCode' => 'KES',
            'amount' => '600.00',
        ],
        [
            'transactionId' => 'ATXid_520e732ea1191c1f03a7d9bea3a91006',
            'phoneNumber' => '+254720123123',
            'sourceIpAddress' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
            'currencyCode' => 'UGX',
            'amount' => '9000.00',
        ],
    ],
]);

dataset('bulk-sms-opt-out-notification', [
    [
        [
            'senderId' => '220225',
            'phoneNumber' => '+254720123123',
        ],
        [
            'senderId' => 'COMPANY',
            'phoneNumber' => '+254720123123',
        ],
    ],
]);

dataset('sms-delivery-report-notification', [
    [
        [
            'id' => 'ATXid_520e732ea1191c1f03a7d9bea3a91006',
            'phoneNumber' => '+254720123123',
            'retryCount' => faker()->numberBetween(0, 5),
        ],
        [
            'id' => 'ATXid_520e732ea1191c1f03a7d9bea3a91006',
            'phoneNumber' => '+254720123123',
            'retryCount' => faker()->numberBetween(0, 5),
            'status' => 'Rejected',
        ],
        [
            'id' => 'ATXid_520e732ea1191c1f03a7d9bea3a91006',
            'phoneNumber' => '+254720123123',
            'retryCount' => faker()->numberBetween(0, 5),
            'status' => 'Failed',
        ],
    ],
]);

dataset('ussd-event-notification', [
    [
        [
            'durationInMillis' => faker()->numberBetween(100, 10000),
            'phoneNumber' => '+254720123123',
            'errorMessage' => '',
            'serviceCode' => '*100#',
            'lastAppResponse' => 'CON Enter your Acc No.',
            'hopsCount' => faker()->numberBetween(0, 10),
            'cost' => faker()->numberBetween(0, 10),
            'date' => faker()->dateTime()->format('Y-m-d H:i:s'),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'retryCount' => faker()->numberBetween(0, 5),
            'input' => 'KEY BAR KEY',
            'networkCode' => '99999',
            'status' => 'Incomplete',
        ],
        [
            'durationInMillis' => faker()->numberBetween(100, 10000),
            'phoneNumber' => '+254720123123',
            'errorMessage' => '',
            'serviceCode' => '*100#',
            'lastAppResponse' => 'CON Enter your Acc No.',
            'hopsCount' => faker()->numberBetween(0, 10),
            'cost' => faker()->numberBetween(0, 10),
            'date' => faker()->dateTime()->format('Y-m-d H:i:s'),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'retryCount' => faker()->numberBetween(0, 5),
            'input' => '',
            'networkCode' => '99999',
            'status' => 'Incomplete',
        ],
        [
            'durationInMillis' => faker()->numberBetween(100, 10000),
            'phoneNumber' => '+254720123123',
            'errorMessage' => '',
            'serviceCode' => '*100#',
            'lastAppResponse' => 'CON Enter your Acc No.',
            'hopsCount' => faker()->numberBetween(0, 10),
            'cost' => faker()->numberBetween(0, 10),
            'date' => faker()->dateTime()->format('Y-m-d H:i:s'),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'retryCount' => faker()->numberBetween(0, 5),
            'input' => null,
            'networkCode' => '99999',
            'status' => 'Incomplete',
        ],
        [
            'durationInMillis' => faker()->numberBetween(100, 10000),
            'phoneNumber' => '+254720123123',
            'errorMessage' => '',
            'serviceCode' => '*100#',
            'lastAppResponse' => 'CON Enter your Acc No.',
            'hopsCount' => faker()->numberBetween(0, 10),
            'cost' => faker()->numberBetween(0, 10),
            'date' => faker()->dateTime()->format('Y-m-d H:i:s'),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'retryCount' => faker()->numberBetween(0, 5),
            'networkCode' => '99999',
            'status' => 'Incomplete',
        ],
    ],
]);

dataset('ussd-session-notification', [
    [
        [
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'phoneNumber' => '+254720123123',
            'serviceCode' => '*100#',
            'text' => 'KEY BAR KEY',
        ],
    ],
]);

dataset('incoming-message-notification', [
    [
        [
            'date' => faker()->dateTime()->format('Y-m-d H:i:s'),
            'from' => '+254720123123',
            'id' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'linkId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'text' => faker()->sentences(asText: true),
            'to' => (string)faker()->numberBetween(1000, 99999),
            'networkCode' => '99999',
        ],
        [
            'date' => faker()->dateTime()->format('Y-m-d H:i:s'),
            'from' => '+254720123123',
            'id' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'linkId' => '',
            'text' => faker()->sentences(asText: true),
            'to' => (string)faker()->numberBetween(1000, 99999),
            'networkCode' => '99999',
        ],
        [
            'date' => faker()->dateTime()->format('Y-m-d H:i:s'),
            'from' => '+254720123123',
            'id' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'text' => faker()->sentences(asText: true),
            'to' => (string)faker()->numberBetween(1000, 99999),
            'networkCode' => '99999',
        ],
    ],
]);

dataset('subscription-notification', [
    [
        [
            'phoneNumber' => '+254720123123',
            'shortCode' => '6942',
            'keyword' => 'ubwedede',
            'updateType' => 'deletion',
        ],
        [
            'phoneNumber' => '+254720123123',
            'shortCode' => '6942',
            'keyword' => 'Magnathombious',
            'updateType' => 'addition',
        ],
    ],
]);

dataset('incoming-voice-call-notification', [
    [
        [
            'isActive' => faker()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'direction' => 'inbound',
            'callerNumber' => '+254720123123',
            'destinationNumber' => '+254709100100',
        ],
        [
            'isActive' => faker()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'direction' => 'outbound',
            'callerNumber' => '+254720123123',
            'destinationNumber' => '+254709100100',
            'dtmfDigits' => '123456',
        ],
        [
            'isActive' => faker()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATVId_b2beff43fbe0d2749cc1693b4df4f585',
            'direction' => 'inbound',
            'callerNumber' => '+254720123123',
            'destinationNumber' => '+254709100100',
            'callSessionState' => 'Completed',
            'callStartTime' => '2022-03-01+16:13:56',
        ],
    ],
]);

dataset('voice-event-notification', [
    [
        [
            'isActive' => faker()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATVId_b2beff43fbe0d2749cc1693b4df4f585',
            'callerNumber' => '+254720123123',
            'destinationNumber' => '+254709100100',
            'callSessionState' => 'Completed',
            'callStartTime' => '2022-03-01+16:13:56',
        ],
    ],
]);
