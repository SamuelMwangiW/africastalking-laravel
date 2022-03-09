<?php

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\ValueObjects\AccountDTO;

it('respects the DTOContract ',function (){
    $account = new AccountDTO(
        balance: 6000,
        currency: 'UGX',
    );

    expect($account)
        ->toBeInstanceOf(DTOContract::class);
});

it('can construct an AccountDTO class',function (){
    $account = new AccountDTO(
        balance: 6000,
        currency: 'UGX',
    );

   expect($account)
       ->toBeInstanceOf(AccountDTO::class)
       ->currency->toBe('UGX')
       ->balance->toBe(6000.00);
});

it('can be cast to string',function (){
    $account = new AccountDTO(
        balance: 6000,
        currency: 'UGX',
    );

    expect((string)$account)
        ->toBe('UGX 6000');
});

it('can be cast to array',function (){
    $account = new AccountDTO(
        balance: 6000,
        currency: 'UGX',
    );

    expect((array)$account)
        ->toBe(['balance' => 6000.0,'currency' => 'UGX']);
});
