<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Concerns\HasIdempotency;
use SamuelMwangiW\Africastalking\Enum\BundlesUnit;
use SamuelMwangiW\Africastalking\Enum\BundlesValidity;
use SamuelMwangiW\Africastalking\Saloon\Requests\MobileData\SendRequest;
use SamuelMwangiW\Africastalking\ValueObjects\DataBundlesResponse;
use SamuelMwangiW\Africastalking\ValueObjects\MobileDataTransaction;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

class MobileData
{
    use HasIdempotency;

    /** @var Collection<int,MobileDataTransaction> $recipients */
    public Collection $recipients;

    public string $productName;

    public function __construct()
    {
        $this->recipients = collect([]);
        $this->productName = config('africastalking.payment.product-name');
    }

    public function productName(string $name): MobileData
    {
        $this->productName = $name;

        return $this;
    }

    public function to(
        PhoneNumber|string $phoneNumber,
        int                $quantity,
        BundlesValidity    $validity,
        BundlesUnit        $unit = BundlesUnit::MB,
        bool               $isPromoBundle = false,
        array              $meta = [],
    ): MobileData {
        if (is_string($phoneNumber)) {
            $phoneNumber = PhoneNumber::make($phoneNumber);
        }

        $transaction = MobileDataTransaction::make(
            phoneNumber: $phoneNumber,
            quantity: $quantity,
            validity: $validity,
            unit: $unit,
            isPromoBundle: $isPromoBundle,
            meta: $meta,
        );

        $this->recipients->push($transaction);

        return $this;
    }

    public function send(): DataBundlesResponse
    {
        $request = SendRequest::make(
            productName: $this->productName,
            recipients: $this->recipients
                ->map(
                    fn(MobileDataTransaction $transaction) => $transaction->toArray(),
                )->toArray(),
        );

        if ($this->idempotencyKey()) {
            $request->headers()->add('Idempotency-Key', $this->idempotencyKey());
        }

        return $request->send()->throw()->dto();
    }
}
