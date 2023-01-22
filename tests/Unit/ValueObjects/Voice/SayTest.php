<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\ValueObjects\Voice\Action;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Say;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\SynthesisedSpeech;

it('implements the say action')
    ->expect(app(Say::class))->toBeInstanceOf(Action::class);

it('builds to xml')
    ->expect(
        Say::make(
            message: 'Test say action message',
            playBeep: true,
            voice: 'en-US-Standard-C',
        )->build()
    )->toBe(expected: '<Say voice="en-US-Standard-C" playBeep="true">Test say action message</Say>');

it('sets the playBeep option')
    ->expect(
        Say::make('Test say action message')
            ->playBeep()
            ->build()
    )->toBe(expected: '<Say playBeep="true">Test say action message</Say>');

it('skips the playBeep option when false')
    ->expect(
        Say::make('Test say action message')
            ->playBeep(false)
            ->build()
    )->toBe(expected: '<Say>Test say action message</Say>');

it('sets the voice option')
    ->expect(
        Say::make('Test say action message')
            ->voice('en-US-Standard-C')
            ->build()
    )->toBe(expected: '<Say voice="en-US-Standard-C">Test say action message</Say>');

it('sets synthesized speech attributes with a break', function (): void {
    $say = Say::make(
        fn (SynthesisedSpeech $speech) => $speech
            ->say('Take a deep breath.')
            ->break('200ms')
            ->say('exhale.'),
        voice: 'en-US-Wavenet-C'
    )->build();

    expect($say)
        ->toBe('<Say voice="en-US-Wavenet-C"><speak>Take a deep breath.<break time="200ms"/>exhale.</speak></Say>');
});

it('sets synthesized speech attributes with say as', function (): void {
    $say = Say::make(
        fn (SynthesisedSpeech $speech) => $speech
            ->say('There are ')
            ->sayAsCardinal('2006')
            ->say(' people on the waiting list to attend the ')
            ->sayAsOrdinal('2')
            ->say(' conference on ')
            ->sayAsCharacters('CAS')
            ->say(' which will be held on ')
            ->sayAsDate('2030-09-04.')
            ->say('. The charges will be')
            ->sayAsCurrency('$20', 'en-US')
            ->say(' payable at ')
            ->sayAsDate('6:42AM')
            ->bleep(' not so nice words'),
        voice: 'en-US-Wavenet-C'
    )->build();

    expect($say)
        ->toBe(
            '<Say voice="en-US-Wavenet-C"><speak>There are <say-as interpret-as="cardinal">2006</say-as> people on the waiting list to attend the <say-as interpret-as="ordinal">2</say-as> conference on <say-as interpret-as="characters">CAS</say-as> which will be held on <say-as interpret-as="date" format="yyyymmdd" detail="1">2030-09-04.</say-as>. The charges will be<say-as interpret-as="currency" language="en-US">$20</say-as> payable at <say-as interpret-as="date" format="yyyymmdd" detail="1">6:42AM</say-as><say-as interpret-as="bleep"> not so nice words</say-as></speak></Say>'
        );
});

it('sets synthesized speech attributes with emphasis', function (): void {
    $say = Say::make(
        fn (SynthesisedSpeech $speech) => $speech
            ->emphasis('Please call back.', 'strong'),
        voice: 'en-US-Wavenet-C'
    )->build();

    expect($say)->toBe(
        expected: '<Say voice="en-US-Wavenet-C"><speak><emphasis level="strong">Please call back.</emphasis></speak></Say>'
    );
});
