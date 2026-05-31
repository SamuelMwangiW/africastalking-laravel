# About This Package

`africastalking-laravel` is an unofficial Laravel SDK for [Africa's Talking](https://africastalking.com/) APIs. It wraps the Africa's Talking REST APIs in a fluent, Laravel-idiomatic interface so you can integrate SMS, airtime, payments, voice, USSD, and SIM Swap detection without writing boilerplate HTTP code.

## Why This Package?

Africa's Talking provides powerful APIs for building telecom-driven applications across Africa. This SDK makes those APIs accessible within Laravel by leveraging the framework's native components:

| Laravel Feature | How It's Used |
|---|---|
| HTTP Client | All API requests — no raw Guzzle |
| Service Container | Facade and helper function binding |
| Notifications | Route notifications via Africastalking SMS |
| Collections | API responses returned as typed Collections |
| Form Requests | Typed, validated callback request objects |
| Config | Centralised credentials management |

## Supported APIs

| Service | Feature |
|---|---|
| **Application** | Fetch account balance |
| **SMS** | Bulk, Premium, and On-Demand messages |
| **Airtime** | Disburse airtime to one or many numbers |
| **USSD** | Handle USSD sessions and events |
| **Payments** | Mobile checkout, wallet balance, stash top-up |
| **Voice** | Outbound calls, IVR responses, call recording |
| **WebRTC** | Generate browser client tokens |
| **Insights** | SIM Swap detection |

## Sandbox vs. Production

Africa's Talking provides a [sandbox environment](https://sandbox.africastalking.com/) for testing. Set `AFRICASTALKING_USERNAME=sandbox` in your `.env` to use it — no real money or messages will be sent.

Switch to your live credentials when you're ready for production.

## Relationship to the Official Docs

This SDK and its documentation complement the [official Africa's Talking developer docs](https://developers.africastalking.com/docs). It is strongly recommended to keep the official docs bookmarked — they cover API limits, network-specific behaviour, and error codes that go beyond the scope of this SDK.
