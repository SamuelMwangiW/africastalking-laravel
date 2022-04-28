<?php

use function Pest\Faker\faker;

dataset('payment-amount', [
    fn () => faker()->numberBetween(1, 7) * 10000,
]);
