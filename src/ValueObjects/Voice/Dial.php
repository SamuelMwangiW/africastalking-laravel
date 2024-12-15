<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

use Illuminate\Support\Collection;

class Dial implements Action, CallActionItem
{
    /**
     * @var Collection<int,string>
     */
    private Collection $recipients;
    private bool $record;
    private ?string $ringBackTone;
    private int $maxDuration;
    private bool $sequential;
    private ?string $callerId;

    public static function make(
        array       $phoneNumbers,
        bool        $record = false,
        string|null $ringBackTone = null,
        int         $maxDuration = 0,
        bool        $sequential = false,
        string|null $callerId = null,
    ): Dial {
        return (new Dial())
            ->phoneNumbers($phoneNumbers)
            ->record($record)
            ->ringBackTone($ringBackTone)
            ->maxDuration($maxDuration)
            ->sequential($sequential)
            ->callerId($callerId);
    }

    public function build(): string
    {
        $options = " phoneNumbers=\"{$this->recipients->implode(',')}\"";
        $options .= " sequential=\"{$this->booleanString($this->sequential)}\"";
        $options .= " record=\"{$this->booleanString($this->record)}\"";

        if ($this->maxDuration) {
            $options .= " maxDuration=\"{$this->maxDuration}\"";
        }

        if ($this->ringBackTone) {
            $options .= " ringbackTone=\"{$this->ringBackTone}\"";
        }

        if ($this->callerId) {
            $options .= " callerId=\"{$this->callerId}\"";
        }

        return "<Dial{$options}/>";
    }

    public function buildJson(): array
    {
        return [
            'actionType' => 'Dial',
            'phoneNumbers' => $this->recipients->toArray(),
            'record' => $this->record,
            'sequential' => $this->sequential,
        ];
    }

    public function phoneNumbers(array $phoneNumbers): static
    {
        $this->recipients = collect($phoneNumbers);

        return $this;
    }

    public function record(bool $record = true): static
    {
        $this->record = $record;

        return $this;
    }

    public function ringBackTone(string|null $ringBackTone): static
    {
        $this->ringBackTone = $ringBackTone;

        return $this;
    }

    public function maxDuration(int $maxDuration): static
    {
        $this->maxDuration = $maxDuration;

        return $this;
    }

    public function sequential(bool $sequential = true): static
    {
        $this->sequential = $sequential;

        return $this;
    }

    public function callerId(?string $callerId): static
    {
        $this->callerId = $callerId;

        return $this;
    }

    private function booleanString(bool $value): string
    {
        return $value ? 'true' : 'false';
    }
}
