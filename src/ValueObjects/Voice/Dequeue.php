<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

class Dequeue implements Action
{
    public function __construct(
        public ?string $name = null,
        public ?string $phoneNumber = null
    ) {}

    public static function make(
        ?string $name = null,
        ?string $phoneNumber = null
    ): Dequeue {
        return new Dequeue(
            name: $name,
            phoneNumber: $phoneNumber,
        );
    }

    public function queue(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function build(): string
    {
        $options = $this->name ? "name=\"{$this->name}\" " : null;

        return "<Dequeue {$options}phoneNumber=\"{$this->phoneNumber()}\" />";
    }

    private function phoneNumber(): string
    {
        return $this->phoneNumber ?? config('africastalking.voice.from');
    }
}
