<?php

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

class Reject implements Action
{
    public static function make(): Reject
    {
        return new Reject();
    }

    public function build(): string
    {
        return '<Reject/>';
    }
}
