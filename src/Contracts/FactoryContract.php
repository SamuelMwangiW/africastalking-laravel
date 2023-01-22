<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Contracts;

interface FactoryContract
{
    public static function make(array $data): DTOContract;
}
