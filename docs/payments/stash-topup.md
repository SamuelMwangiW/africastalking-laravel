# Stash top up

```php
africastalking()
    ->stash()
    ->topup('TZS',100000);

//or fluently
africastalking()
    ->stash()
    ->amount(10000)
    ->currency('USD')
    ->product('My Product') //To override the product name in config
    ->topup(); //topup() has an alias named send() if you fancy

```