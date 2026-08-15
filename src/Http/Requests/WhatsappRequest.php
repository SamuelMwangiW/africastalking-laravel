<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WhatsappRequest extends FormRequest
{
    private const array MEDIA_TYPES = ['Document', 'Image', 'Video'];
    public function rules(): array
    {
        return [
            'body' => ['required', Rule::array(['message', 'url', 'mediaType', 'caption'])],
            'body.message' => [
                'string',
                Rule::requiredIf(fn() => 'Text' === $this->input('messageType')),
            ],
            'body.url' => [
                'string',
                'url',
                'starts_with:https://',
                Rule::requiredIf(fn() => $this->hasMedia()),
            ],
            'body.mediaType' => [
                'required',
                'string',
                Rule::in(self::MEDIA_TYPES),
                Rule::requiredIf($this->hasMedia()),
            ],
            'body.caption' => [
                'sometimes',
                'string',
                Rule::prohibitedIf(fn() => ! $this->hasMedia()),
            ],
            'from' => ['required', 'string', 'min:10', 'max:18'],
            'gatewayId' => ['required', 'string', 'min:62', 'max:68'],
            'messageId' => ['required', 'string', 'min:24', 'max:36'],
            'messageType' => ['required', 'string', Rule::in(['Image', 'Document', 'Text', 'Video'])],
            'waNumber' => ['required', 'string', 'min:10', 'max:18'],
        ];
    }

    public function hasMedia(): bool
    {
        return in_array(
            needle: $this->input('messageType'),
            haystack: self::MEDIA_TYPES,
            strict: true,
        );
    }

    public function mediaUrl(): string
    {
        return $this->str(key: 'body.url')->value();
    }
}
