<?php

use function Pest\Faker\faker;

dataset('payment-amount', [
    fn () => faker()->numberBetween(10000, 70000),
]);
