<?php

use function Pest\Faker\faker;

dataset('payment-amount', [
    fn () => faker()->numberBetween(10_000, 70_000),
]);
