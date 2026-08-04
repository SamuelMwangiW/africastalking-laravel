<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests;

use GuzzleHttp\Promise\PromiseInterface;
use ReflectionException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Http\Request;
use Saloon\Http\Response;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\AfricastalkingConnector;

/**
 * @mixin AfricastalkingConnector
 */
abstract class BaseRequest extends Request implements HasBody
{
    public Service $service;
    protected Method $method = Method::POST;

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function send(): Response
    {
        return app(AfricastalkingConnector::class)
            ->service($this->service)
            ->send($this);
    }

    /**
     * Sends this request asynchronously.
     *
     * Deliberately uses a fresh connector instance rather than the shared
     * container-bound one: Saloon only resolves the base URL once the
     * deferred async task actually runs, so reusing the shared connector's
     * mutable service() across concurrent async requests targeting
     * different services would race.
     */
    public function sendAsync(): PromiseInterface
    {
        return (new AfricastalkingConnector())
            ->service($this->service)
            ->sendAsync($this);
    }

    public function defaultHeaders(): array
    {
        return array_filter([
            'apiKey' => config(key: 'africastalking.api-key'),
            'User-Agent' => 'samuelmwangiw/africastalking-laravel',
        ]);
    }

    public function username(): string
    {
        return config(key: 'africastalking.username');
    }
}
