<?php

namespace SamuelMwangiW\Africastalking\Contracts;

interface FactoryContract
{
    public static function make(array $data): DTOContract;
}
