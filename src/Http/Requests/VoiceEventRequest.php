<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\CallHangupCauses;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Enum\Direction;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasCallAttributes;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;
use SamuelMwangiW\Africastalking\Jobs\DownloadCallRecording;

class VoiceEventRequest extends FormRequest
{
    use HasCallAttributes;
    use HasPhoneNumber;
    use HasUniqueId;

    public function rules(): array
    {
        return [
            'isActive' => ['required', 'boolean'],
            'sessionId' => ['required', 'string', 'min:32'],
            'direction' => ['required', 'string', new Enum(Direction::class)],
            'callerNumber' => ['required', 'string', 'min:10'],
            'destinationNumber' => ['required', 'string', 'min:10'],
            'dtmfDigits' => ['nullable', 'string'],
            'callSessionState' => ['nullable', 'string'],
            'callerCarrierName' => ['nullable', 'string'],
            'callerCountryCode' => ['nullable', 'string', 'max:4'],
            'callStartTime' => ['nullable', 'string'],
            'recordingUrl' => ['nullable', 'url'],
            'durationInSeconds' => ['nullable', 'int', 'min:0'],
            'currencyCode' => ['nullable', 'string', new Enum(Currency::class)],
            'amount' => ['nullable', 'numeric'],
            'dialDestinationNumber' => ['nullable', 'string'],
            'dialDurationInSeconds' => ['nullable', 'integer', 'min:0'],
            'dialStartTime' => ['nullable', 'date'],
            'hangupCause' => ['nullable', 'string', new Enum(CallHangupCauses::class)],
        ];
    }

    public function downloadRecording(?string $disk = null, ?string $path = null): void
    {
        if ($this->isEmptyString('recordingUrl')) {
            return;
        }

        if (0 === $this->integer('durationInSeconds')) {
            return;
        }

        DownloadCallRecording::dispatch(
            $this->input('recordingUrl'),
            $this->id(),
            $disk,
            $path,
        );
    }

    protected function phoneNumberKey(): string
    {
        return 'callerNumber';
    }

    protected function idKey(): string
    {
        return 'sessionId';
    }
}
