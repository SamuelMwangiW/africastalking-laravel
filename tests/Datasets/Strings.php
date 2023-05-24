<?php

declare(strict_types=1);

dataset('strings', function () {
    yield fake()->word();
    yield fake()->word();
    yield fake()->word();
    yield fake()->word();
    yield fake()->word();
});

dataset('sentence', function () {
    yield fake()->bs();
    //    yield fake()->catchPhrase();
    //    yield fake()->catchPhrase();
    //    yield fake()->catchPhrase();
    //    yield fake()->catchPhrase();
});
