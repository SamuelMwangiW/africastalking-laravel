<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Payment;

use Illuminate\Support\Str;
use Saloon\Enums\Method;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

class WalletBalanceRequest extends BaseRequest
{
    use HasJsonBody;

    public Service $service = Service::DATA;
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'query/wallet/balance';
    }

    public function defaultQuery(): array
    {
        return [
            'username' => $this->username(),
        ];
    }

    public function createDtoFromResponse(Response $response): Balance
    {
        $balance = Str::of($response->json('balance'))->after(' ')->toString();
        $currency = Str::of($response->json('balance'))->before(' ')->toString();

        return Balance::make(
            balance: floatval($balance),
            currency: Currency::from($currency),
        );
    }
}
