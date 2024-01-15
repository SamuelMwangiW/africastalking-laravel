<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Enum\CallHangupCauses;

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
            'retryCount' => fake()->numberBetween(0, 5),
        ],
        [
            'id' => 'ATXid_520e732ea1191c1f03a7d9bea3a91006',
            'phoneNumber' => '+254720123123',
            'retryCount' => fake()->numberBetween(0, 5),
            'status' => 'Rejected',
        ],
        [
            'id' => 'ATXid_520e732ea1191c1f03a7d9bea3a91006',
            'phoneNumber' => '+254720123123',
            'retryCount' => fake()->numberBetween(0, 5),
            'status' => 'Failed',
        ],
    ],
]);

dataset('ussd-event-notification', [
    [
        [
            'durationInMillis' => fake()->numberBetween(100, 10000),
            'phoneNumber' => '+254720123123',
            'errorMessage' => '',
            'serviceCode' => '*100#',
            'lastAppResponse' => 'CON Enter your Acc No.',
            'hopsCount' => fake()->numberBetween(0, 10),
            'cost' => fake()->numberBetween(0, 10),
            'date' => fake()->dateTime()->format('Y-m-d H:i:s'),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'retryCount' => fake()->numberBetween(0, 5),
            'input' => 'KEY BAR KEY',
            'networkCode' => '99999',
            'status' => 'Incomplete',
        ],
        [
            'durationInMillis' => fake()->numberBetween(100, 10000),
            'phoneNumber' => '+254720123123',
            'errorMessage' => '',
            'serviceCode' => '*100#',
            'lastAppResponse' => 'CON Enter your Acc No.',
            'hopsCount' => fake()->numberBetween(0, 10),
            'cost' => fake()->numberBetween(0, 10),
            'date' => fake()->dateTime()->format('Y-m-d H:i:s'),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'retryCount' => fake()->numberBetween(0, 5),
            'input' => '',
            'networkCode' => '99999',
            'status' => 'Incomplete',
        ],
        [
            'durationInMillis' => fake()->numberBetween(100, 10000),
            'phoneNumber' => '+254720123123',
            'errorMessage' => '',
            'serviceCode' => '*100#',
            'lastAppResponse' => 'CON Enter your Acc No.',
            'hopsCount' => fake()->numberBetween(0, 10),
            'cost' => fake()->numberBetween(0, 10),
            'date' => fake()->dateTime()->format('Y-m-d H:i:s'),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'retryCount' => fake()->numberBetween(0, 5),
            'input' => null,
            'networkCode' => '99999',
            'status' => 'Incomplete',
        ],
        [
            'durationInMillis' => fake()->numberBetween(100, 10000),
            'phoneNumber' => '+254720123123',
            'errorMessage' => '',
            'serviceCode' => '*100#',
            'lastAppResponse' => 'CON Enter your Acc No.',
            'hopsCount' => fake()->numberBetween(0, 10),
            'cost' => fake()->numberBetween(0, 10),
            'date' => fake()->dateTime()->format('Y-m-d H:i:s'),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'retryCount' => fake()->numberBetween(0, 5),
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
            'date' => fake()->dateTime()->format('Y-m-d H:i:s'),
            'from' => '+254720123123',
            'id' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'linkId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'text' => fake()->sentences(asText: true),
            'to' => (string) fake()->numberBetween(1000, 99999),
            'networkCode' => '99999',
        ],
        [
            'date' => fake()->dateTime()->format('Y-m-d H:i:s'),
            'from' => '+254720123123',
            'id' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'linkId' => '',
            'text' => fake()->sentences(asText: true),
            'to' => (string) fake()->numberBetween(1000, 99999),
            'networkCode' => '99999',
        ],
        [
            'date' => fake()->dateTime()->format('Y-m-d H:i:s'),
            'from' => '+254720123123',
            'id' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'text' => fake()->sentences(asText: true),
            'to' => (string) fake()->numberBetween(1000, 99999),
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
            'updateType' => 'Deletion',
        ],
        [
            'phoneNumber' => '+254720123123',
            'shortCode' => '6942',
            'keyword' => 'Magnathombious',
            'updateType' => 'Addition',
        ],
    ],
]);

dataset('incoming-voice-call-notification', [
    [
        [
            'isActive' => fake()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'direction' => 'Inbound',
            'callerNumber' => '+254720123123',
            'destinationNumber' => '+254709100100',
        ],
        [
            'isActive' => fake()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATUid_5d3b4c2bc589f4811820a7184eed4df5',
            'direction' => 'Outbound',
            'callerNumber' => '+254720123123',
            'destinationNumber' => '+254709100100',
            'dtmfDigits' => '123456',
        ],
        [
            'isActive' => fake()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATVId_b2beff43fbe0d2749cc1693b4df4f585',
            'direction' => 'Inbound',
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
            'isActive' => fake()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATVId_b2beff43fbe0d2749cc1693b4df4f585',
            'callerNumber' => '+254720123123',
            'destinationNumber' => '+254709100100',
            'callSessionState' => 'Completed',
            'callStartTime' => '2022-03-01+16:13:56',
        ],
        [
            'isActive' => fake()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATVId_b2beff43fbe0d2749cc1693b4df4f585',
            'direction' => SamuelMwangiW\Africastalking\Enum\Direction::INBOUND->value,
            'callerNumber' => '+254720123123',
            'destinationNumber' => '+254709100100',
            'dtmfDigits' => '123#',
            'callSessionState' => 'Completed',
            'callerCarrierName' => 'Safaricom',
            'callerCountryCode' => 'KE',
            'callStartTime' => '2022-03-01+16:13:56',
            'recordingUrl' => 'https://example.com/somerandomtexthere.mp3',
            'durationInSeconds' => '420',
            'currencyCode' => 'KES',
            'amount' => '100',
            'dialDestinationNumber' => '+254711000000',
            'dialDurationInSeconds' => '69',
            'dialStartTime' => '2023-02-23 11:52:12',
            'hangupCause' => CallHangupCauses::NO_USER_RESPONSE->value,
        ],
    ],
]);

dataset('voice-event-notification-with-recording', [
    [
        [
            'isActive' => fake()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATVId_b2beff43fbe0d2749cc1693b4df4f585',
            'direction' => SamuelMwangiW\Africastalking\Enum\Direction::INBOUND->value,
            'callerNumber' => '+254720123123',
            'destinationNumber' => '+254709100100',
            'dtmfDigits' => '123#',
            'callSessionState' => 'Completed',
            'callerCarrierName' => 'Safaricom',
            'callerCountryCode' => 'KE',
            'callStartTime' => '2022-03-01+16:13:56',
            'recordingUrl' => 'https://example.com/somerandomtexthere.mp3',
            'durationInSeconds' => '420',
            'currencyCode' => 'KES',
            'amount' => '100',
            'dialDestinationNumber' => '+254711000000',
            'dialDurationInSeconds' => '69',
            'dialStartTime' => '2023-02-23+11:52:12',
            'hangupCause' => CallHangupCauses::NO_USER_RESPONSE->value,
        ],
    ],
]);

dataset('voice-event-notification-with-0-duration', [
    [
        [
            'isActive' => fake()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATVId_b2beff43fbe0d2749cc1693b4df4f585',
            'direction' => SamuelMwangiW\Africastalking\Enum\Direction::INBOUND->value,
            'callerNumber' => '+254720123123',
            'destinationNumber' => '+254709100100',
            'dtmfDigits' => '123#',
            'callSessionState' => 'Completed',
            'callerCarrierName' => 'Safaricom',
            'callerCountryCode' => 'KE',
            'callStartTime' => '2022-03-01+16:13:56',
            'recordingUrl' => 'https://example.com/somerandomtexthere.mp3',
            'durationInSeconds' => '0',
            'currencyCode' => 'KES',
            'amount' => '100',
            'dialDestinationNumber' => '+254711000000',
            'dialDurationInSeconds' => '0',
            'dialStartTime' => '2023-02-23+11:52:12',
            'hangupCause' => CallHangupCauses::NO_USER_RESPONSE->value,
        ],
    ],
]);

dataset('voice-event-notification-with-empty-recordingUrl', [
    [
        [
            'isActive' => fake()->randomElement([0, 1, true, false]),
            'sessionId' => 'ATVId_b2beff43fbe0d2749cc1693b4df4f585',
            'direction' => SamuelMwangiW\Africastalking\Enum\Direction::INBOUND->value,
            'callerNumber' => '+254720123123',
            'destinationNumber' => '+254709100100',
            'dtmfDigits' => '123#',
            'callSessionState' => 'Completed',
            'callerCarrierName' => 'Safaricom',
            'callerCountryCode' => 'KE',
            'callStartTime' => '2022-03-01+16:13:56',
            'recordingUrl' => '',
            'durationInSeconds' => '1',
            'currencyCode' => 'KES',
            'amount' => '100',
            'dialDestinationNumber' => '+254711000000',
            'dialDurationInSeconds' => '1',
            'dialStartTime' => '2023-02-23+11:52:12',
            'hangupCause' => CallHangupCauses::NO_USER_RESPONSE->value,
        ],
    ],
]);

dataset('mobile-c2b-notification', [
    [
        [
            'clientAccount' => fake()->word(),
            'productName' => fake()->word(),
            'phoneNumber' => fake()->e164PhoneNumber(),
            'value' => 'KES '.fake()->numberBetween(100, 1000),
            'providerMetadata' => ['foo' => 'bar', 'baz' => 'quo'],
        ],
        [
            'productName' => fake()->word(),
            'phoneNumber' => fake()->e164PhoneNumber(),
            'value' => 'KES '.fake()->numberBetween(100, 1000),
            'providerMetadata' => ['foo' => 'bar', 'baz' => 'quo'],
        ],
        [
            'clientAccount' => fake()->word(),
            'productName' => fake()->word(),
            'phoneNumber' => fake()->e164PhoneNumber(),
            'value' => 'KES '.fake()->numberBetween(100, 1000),
        ],
        [
            'productName' => fake()->word(),
            'phoneNumber' => fake()->e164PhoneNumber(),
            'value' => 'KES '.fake()->numberBetween(100, 1000),
        ],
    ],
]);

dataset('payment-notification', [
    [
        [
            'transactionId' => 'ATVId_b2beff43fbe0d2749cc1693b4df4f585',
            'providerRefId' => 'QX123ERQT',
            'providerChannel' => 'StashTopup',
            'clientAccount' => '123',
            'productName' => 'Test Product',
            'source' => 'PaymentWallet',
            'destination' => 'StashTopup',
            'value' => 'KES 10000.00',
            'description' => 'Topped up user stash. New Stash Balance: KES 9798391.5303',
            'requestMetadata' => ['id' => 1233, 'code' => 'UUID1234'],
            'transactionDate' => '2022-04-29 01:44:51',
            'origin' => 'ApiRequest',
            'direction' => 'Inbound',
        ],
        [
            'transactionId' => 'ATVId_b2beff43fbe0d2749cc1693b4df4f585',
            'providerRefId' => 'QX123ERQT',
            'providerChannel' => 'StashTopup',
            'clientAccount' => '123',
            'productName' => 'Test Product',
            'source' => 'PaymentWallet',
            'destination' => 'StashTopup',
            'value' => 'KES 10000.00',
            'description' => 'Topped up user stash. New Stash Balance: KES 9798391.5303',
            'requestMetadata' => ['id' => 1233, 'code' => 'UUID1234'],
            'transactionDate' => '2022-04-29 01:44:51',
            'origin' => 'ApiRequest',
            'direction' => 'Outbound',
        ],
    ],
]);
