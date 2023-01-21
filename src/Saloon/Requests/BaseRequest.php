<?php

namespace SamuelMwangiW\Africastalking\Saloon\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Http\Request;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\AfricastalkingConnector;

/**
 * @mixin AfricastalkingConnector
 */

abstract class BaseRequest extends Request implements HasBody
{
    public Service $service;
    protected Method $method = Method::POST;
    protected ?string $connector = AfricastalkingConnector::class;

    /**
     * @throws InvalidResponseClassException
     * @throws \ReflectionException
     * @throws PendingRequestException
     */
    public function send(): Response
    {
        $connector = new AfricastalkingConnector();
        $connector->service($this->service);
        $this->body()->add('username', $this->username());

        return $connector->send($this);
    }

    public function defaultHeaders(): array
    {
        return [
            'apiKey' => config(key: 'africastalking.api-key'),
            'User-Agent' => 'samuelmwangiw/africastalking-laravel',
        ];
    }

    public function username(): string
    {
        return config(key: 'africastalking.username');
    }
}
