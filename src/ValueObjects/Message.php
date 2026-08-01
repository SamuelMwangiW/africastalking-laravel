<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Collection;
use ReflectionException;
use Saloon\Http\Response;
use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Saloon\AfricastalkingConnector;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\BulkSmsRequest;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\PremiumSmsRequest;
use Throwable;

class Message implements DTOContract
{
    public int $bulkSMSMode = 1;
    public bool $isBulk = true;
    public bool $async = false;
    public int $enqueue = 1;
    public ?string $keyword = null;
    public ?string $linkId = null;
    public ?int $retryDurationInHours = null;

    /**
     * @param string|null $message
     * @param Collection<int,PhoneNumber>|null $to
     * @param string|null $from
     */
    public function __construct(
        public ?string $message = null,
        public ?Collection $to = null,
        public ?string $from = null,
    ) {}

    public function __toString(): string
    {
        return strval(json_encode($this));
    }

    /**
     * @return array<string,mixed>
     */
    public function __toArray(): array
    {
        return [
            'bulkSMSMode' => $this->bulkSMSMode,
            'enqueue' => $this->enqueue,
            'keyword' => $this->keyword,
            'linkId' => $this->linkId,
            'retryDurationInHours' => $this->retryDurationInHours,
            'message' => $this->message,
            'to' => $this->to?->toArray(),
            'from' => $this->from(),
            'isBulk' => $this->isBulk,
            'isPremium' => ! $this->isBulk,
        ];
    }

    public function enqueue(bool|int $value = true): static
    {
        $this->enqueue = $value ? 1 : 0;

        return $this;
    }

    public function as(?string $from): static
    {
        $this->from = $from;

        return $this;
    }

    public function text(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function message(?string $message): static
    {
        return $this->text($message);
    }

    /**
     * @param Collection<int,PhoneNumber>|string|array $recipients
     * @return $this
     */
    public function to(Collection|string|array $recipients): static
    {
        if (is_string($recipients)) {
            $recipients = [$recipients];
        }

        if (is_array($recipients)) {
            $recipients = collect($recipients)->map(fn($phone) => PhoneNumber::make($phone));
        }

        $this->to = $recipients;

        return $this;
    }

    public function bulk(): static
    {
        $this->isBulk = true;

        return $this;
    }

    public function premium(): static
    {
        $this->isBulk = false;
        $this->bulkSMSMode = 0;

        return $this;
    }

    public function bulkMode(int $value = 1): static
    {
        $this->bulkSMSMode = 1 === $value ? 1 : 0;

        return $this;
    }

    public function async(bool $async = true): static
    {
        $this->async = $async;

        return $this;
    }

    public function keyword(?string $value): static
    {
        $this->keyword = $value;

        return $this;
    }

    public function linkId(?string $value): static
    {
        $this->linkId = $value;

        return $this;
    }

    public function retry(int $value): static
    {
        $this->retryDurationInHours = $value;

        return $this;
    }

    /**
     * @return SentMessageResponse|PromiseInterface
     * @throws AfricastalkingException
     * @throws ReflectionException
     * @throws \Saloon\Exceptions\InvalidResponseClassException
     * @throws \Saloon\Exceptions\PendingRequestException
     * @throws Throwable
     */
    public function send(): SentMessageResponse|PromiseInterface
    {
        $request = $this->request();

        if ($this->async) {
            return $request->sendAsync()->then(
                fn(Response $response) => $this->parse($response),
            );
        }

        return $this->parse($request->send());
    }

    /**
     * Sends many messages concurrently using Saloon's request pool, capped
     * at $concurrency requests in flight at once.
     *
     * All messages in a single pool must share the same sending mode
     * (bulk or premium) — mixing them isn't supported, since it would
     * require resolving a different base URL per request while they're
     * in flight concurrently.
     *
     * @param iterable<int|string,mixed> $messages
     * @param int|Closure(int):int $concurrency
     * @return Collection<int|string,SentMessageResponse|Throwable>
     */
    public function pool(iterable $messages, int|Closure $concurrency = 5): Collection
    {
        $requests = collect($messages)->map(function (mixed $message): BulkSmsRequest|PremiumSmsRequest {
            if ( ! $message instanceof self) {
                throw AfricastalkingException::invalidPoolItem(self::class, $message);
            }

            return $message->request();
        });

        $firstRequest = $requests->first();

        if (null === $firstRequest) {
            return collect();
        }

        $service = $firstRequest->service;

        if ($requests->contains(fn(BulkSmsRequest|PremiumSmsRequest $request) => $request->service !== $service)) {
            throw AfricastalkingException::mixedSmsPoolModes();
        }

        $connector = (new AfricastalkingConnector())->service($service);
        $results = collect();

        $connector->pool(
            requests: $requests,
            concurrency: $concurrency,
            responseHandler: function (Response $response, int|string $key) use (&$results): void {
                try {
                    $results[$key] = $this->parse($response);
                } catch (Throwable $exception) {
                    $results[$key] = $exception;
                }
            },
            exceptionHandler: function (mixed $reason, int|string $key) use (&$results): void {
                $results[$key] = $reason instanceof Throwable ? $reason : new AfricastalkingException((string) $reason);
            },
        )->send()->wait();

        return $results->sortKeys();
    }

    /**
     * @return Collection<int,Collection<int,mixed>>|null
     */
    public function messages(): ?Collection
    {
        return null;
    }

    protected function from(): ?string
    {
        $from = $this->from ?? config('africastalking.sms.from');

        return blank($from) ? null : $from;
    }

    protected function data(): array
    {
        $data = [
            'enqueue' => $this->enqueue,
            'keyword' => $this->keyword,
            'linkId' => $this->linkId,
            'retryDurationInHours' => $this->retryDurationInHours,
            'message' => $this->message,
            'to' => $this->to
                ?->filter(fn(PhoneNumber $number) => $number->isValid())
                ->map(fn(PhoneNumber $number) => $number->number)
                ->implode(','),
        ];

        return array_merge(
            array_filter($data),
            ['from' => $this->from(), 'bulkSMSMode' => $this->bulkSMSMode],
        );
    }

    /**
     * @throws AfricastalkingException
     */
    private function parse(Response $response): SentMessageResponse
    {
        $response->throw();

        if ( ! $response->json('SMSMessageData.Recipients')) {
            throw AfricastalkingException::messageSendingFailed(
                message: $response->json('SMSMessageData.Message'),
            );
        }

        return $response->dto();
    }

    private function request(): BulkSmsRequest|PremiumSmsRequest
    {
        return $this->isBulk
            ? new BulkSmsRequest($this->data())
            : new PremiumSmsRequest($this->data());
    }
}
