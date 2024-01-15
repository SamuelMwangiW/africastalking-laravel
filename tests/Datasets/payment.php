<?php

declare(strict_types=1);

dataset('payment-amount', [
    fn() => fake()->numberBetween(10_000, 70_000),
]);
