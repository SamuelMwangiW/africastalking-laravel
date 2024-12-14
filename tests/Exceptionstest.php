<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\SynthesisedSpeech;

it('is an exception')
    ->expect(AfricastalkingException::class)
    ->toExtend(Exception::class);

it('thows the correct exception')
    ->expect(fn() => AfricastalkingException::notSynthesisedSpeech())
    ->toBeInstanceOf(AfricastalkingException::class)
    ->getMessage()->toBe(
        'The returned object must be an instance of '.SynthesisedSpeech::class,
    );
