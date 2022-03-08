<?php

namespace SamuelMwangiW\Africastalking\Commands;

use Illuminate\Console\Command;

class AfricastalkingCommand extends Command
{
    public $signature = 'africastalking-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
