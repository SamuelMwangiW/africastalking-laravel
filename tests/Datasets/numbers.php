<?php

declare(strict_types=1);

dataset('webrtc-token-duration', function () {
    yield fake()->numberBetween(1, 86400);
});

dataset('invalid-token-duration', function () {
    yield -1;
    yield -100;
    yield 0;
    yield 86401;
});
