<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

class Enqueue implements Action
{
    public function __construct(
        public ?string $name = null,
        public ?string $holdMusic = null,
    ) {}

    public static function make(
        ?string $name = null,
        ?string $holdMusic = null,
    ): Enqueue {
        return new Enqueue(
            name: $name,
            holdMusic: $holdMusic,
        );
    }

    public function queue(string $name): static
    {
        $this->name = $name;

        return $this;
    }
    public function build(): string
    {
        $options = '';

        if ($this->name) {
            $options .= "name=\"{$this->name}\"";
        }

        if ($this->holdMusic) {
            $options .= " holdMusic=\"{$this->holdMusic}\"";
        }

        return "<Enqueue {$options} />";
    }
}
