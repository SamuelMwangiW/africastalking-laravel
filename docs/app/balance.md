# Get Application Balance

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

/** @var \SamuelMwangiW\Africastalking\ValueObjects\Balance $account */
$account = Africastalking::application()->balance();

// Or using the global helper function
$account = africastalking()->application()->balance();
```