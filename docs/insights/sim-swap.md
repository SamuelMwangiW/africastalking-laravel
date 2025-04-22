# SIM Swap

The API operates by providing an additional layer of security for transactions and sensitive operations. When a service detects a request that requires authentication, such as a bank transaction or account login, the API can check the status of the user’s SIM card. It looks for red flags, such as a recent SIM Swap, that could indicate a potential fraud attempt. If suspicious activity is detected, the transaction can be halted, and additional verification steps can be initiated.


```php
// Simple Example
$result = Africastalking::insights()
        ->for('+254722000000')
        ->send();
```

```php
// Alternative
$result = Africastalking::simSwap()
        ->for('+254722000000')
        ->send();
```

```php
// With Multiple numbers
$result = Africastalking::insights()
        ->for('+254711000000')
        ->add('+254722000000')
        ->add('+256786000000')
        ->send();
```

```php
// With Idempotency Key
$result = Africastalking::insights()
        ->for('+254722000000')
        ->idempotent('b457c437-72cd-46b1-b450-d3a12c400810')
        ->send();
```

### Possible Use Cases

- **Financial Institutions**: Enhance the security of online banking and transactions by detecting and preventing unauthorized SIM swaps.
- **Healthcare Providers**: Protect patient confidentiality and secure telemedicine communications against SIM swap attacks.
- **Logistics Companies**: Safeguard supply chain operations and communication channels from unauthorized access and tampering.
- **Manufacturing Enterprises**: Secure mobile-based systems and ensure the integrity of remote asset tracking and control processes.

