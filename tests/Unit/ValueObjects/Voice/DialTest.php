<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\ValueObjects\Voice\Action;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Dial;

it('implements the say action')
    ->expect(app(Dial::class))->toBeInstanceOf(Action::class);

it('builds to xml')
    ->expect(
        Dial::make(
            phoneNumbers: ['+254711123123', '+254733321321'],
            record: true,
            ringBackTone: 'http://mymediafile.com/playme.mp3',
            maxDuration: 24,
            sequential: true,
            callerId: '+256706900900',
        )->build(),
    )->toBe(
        '<Dial phoneNumbers="+254711123123,+254733321321" sequential="true" record="true" maxDuration="24" ringBackTone="http://mymediafile.com/playme.mp3" callerId="+256706900900"/>',
    );

it('sets the record option')
    ->expect(
        Dial::make(['+254711123123', '+254733321321'])
            ->record(true)
            ->build(),
    )->toBe('<Dial phoneNumbers="+254711123123,+254733321321" sequential="false" record="true"/>');

it('overrides the phone numbers passed')
    ->expect(
        Dial::make(['+254711123123', '+254733321321'])
            ->phoneNumbers(['+255790123123','+255710100100'])
            ->build(),
    )->toBe('<Dial phoneNumbers="+255790123123,+255710100100" sequential="false" record="false"/>');

it('shows the record option when false')
    ->expect(
        Dial::make(['+254711123123', '+254733321321'])
            ->record(false)
            ->build(),
    )->toBe('<Dial phoneNumbers="+254711123123,+254733321321" sequential="false" record="false"/>');

it('sets the sequential option with a default of true')
    ->expect(
        Dial::make(['+254711123123', '+254733321321'])
            ->sequential()
            ->build(),
    )->toBe('<Dial phoneNumbers="+254711123123,+254733321321" sequential="true" record="false"/>');

it('shows the sequential option when false')
    ->expect(
        Dial::make(['+254711123123', '+254733321321'])
            ->sequential(false)
            ->build(),
    )->toBe('<Dial phoneNumbers="+254711123123,+254733321321" sequential="false" record="false"/>');

it('sets the ringback tone')
    ->expect(
        Dial::make(['+254711123123', '+254733321321'])
            ->ringBackTone('https://mymediafile.com/playme.mp3')
            ->build(),
    )->toBe('<Dial phoneNumbers="+254711123123,+254733321321" sequential="false" record="false" ringBackTone="https://mymediafile.com/playme.mp3"/>');

it('sets maxDuration')
    ->expect(
        Dial::make(['+254711123123', '+254733321321'])
            ->maxDuration(20)
            ->build(),
    )->toBe('<Dial phoneNumbers="+254711123123,+254733321321" sequential="false" record="false" maxDuration="20"/>');

it('sets callerId')
    ->expect(
        Dial::make(['+254711123123', '+254733321321'])
            ->callerId('+2347012345679')
            ->build(),
    )->toBe('<Dial phoneNumbers="+254711123123,+254733321321" sequential="false" record="false" callerId="+2347012345679"/>');
