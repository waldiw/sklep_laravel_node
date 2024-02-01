<?php

namespace App\Enums;

class ShippingType
{

    const PRZELEW = 'przelew';
    const GOTOWKA = 'gotówka';

    const TYPES = [
        self::PRZELEW,
        self::GOTOWKA,
    ];
}
