<?php

namespace SamuelMwangiW\Africastalking;

use SamuelMwangiW\Africastalking\Domain\Application;

class Africastalking
{
    public function application(): Application
    {
        return app(Application::class);
    }
}
