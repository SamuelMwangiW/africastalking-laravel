<?php

declare(strict_types=1);

use function Pest\Faker\faker;

dataset('strings', function () {
    yield faker()->word();
    yield faker()->word();
    yield faker()->word();
    yield faker()->word();
    yield faker()->word();
});

dataset('sentence', function () {
    yield faker()->bs();
//    yield faker()->catchPhrase();
//    yield faker()->catchPhrase();
//    yield faker()->catchPhrase();
//    yield faker()->catchPhrase();
});
