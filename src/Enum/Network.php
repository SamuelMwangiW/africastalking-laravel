<?php

namespace SamuelMwangiW\Africastalking\Enum;

enum Network: int
{
    case CODE_62120 = 62120;
    case CODE_62130 = 62130;
    case CODE_62150 = 62150;
    case CODE_62160 = 62160;
    case CODE_63510 = 63510;
    case CODE_63513 = 63513;
    case CODE_63514 = 63514;
    case CODE_63902 = 63902;
    case CODE_63903 = 63903;
    case CODE_63907 = 63907;
    case CODE_63999 = 63999;
    case CODE_64002 = 64002;
    case CODE_64003 = 64003;
    case CODE_64004 = 64004;
    case CODE_64005 = 64005;
    case CODE_64007 = 64007;
    case CODE_64009 = 64009;
    case CODE_64101 = 64101;
    case CODE_64110 = 64110;
    case CODE_64111 = 64111;
    case CODE_64114 = 64114;
    case CODE_65001 = 65001;
    case CODE_65010 = 65010;
    case CODE_99999 = 99999;

    public function name(): string
    {
        return match ($this) {
            Network::CODE_62120 => 'Airtel Nigeria',
            Network::CODE_62130 => 'MTN Nigeria',
            Network::CODE_62150 => 'Glo Nigeria',
            Network::CODE_62160 => 'Etisalat Nigeria',
            Network::CODE_63510 => 'MTN Rwanda',
            Network::CODE_63513 => 'Tigo Rwanda',
            Network::CODE_63514 => 'Airtel Rwanda',
            Network::CODE_63902 => 'Safaricom',
            Network::CODE_63903 => 'Airtel Kenya',
            Network::CODE_63907 => 'Orange Kenya',
            Network::CODE_63999 => 'Equitel Kenya',
            Network::CODE_64002 => 'Tigo Tanzania',
            Network::CODE_64003 => 'Zantel Tanzania',
            Network::CODE_64004 => 'Vodacom Tanzania',
            Network::CODE_64005 => 'Airtel Tanzania',
            Network::CODE_64007 => 'TTCL Tanzania',
            Network::CODE_64009 => 'Halotel Tanzania',
            Network::CODE_64101 => 'Airtel Uganda',
            Network::CODE_64110 => 'MTN Uganda',
            Network::CODE_64111 => 'UTL Uganda',
            Network::CODE_64114 => 'Africell Uganda',
            Network::CODE_65001 => 'TNM Malawi',
            Network::CODE_65010 => 'Airtel Malawi',
            Network::CODE_99999 => 'Athena',
        };
    }
}
