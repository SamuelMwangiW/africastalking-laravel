# Making Calls

```php
// Most basic call
africastalking()->voice()
    ->call('+254720123123')
    ->done();

// Call a list of users
africastalking()->voice()
    ->call(['+254720123123','+254731234567'])
    ->done();

// override the callerId
africastalking()->voice()
    ->call('+254720123123')
    ->as('+254711082999')
    ->done();

// Set the call Request Id
africastalking()->voice()
    ->call('+254720123123')
    ->requestId('id_12345')
    ->done();

// You can also use send if like that better
africastalking()->voice()
    ->call('+254720123123')
    ->send();
```