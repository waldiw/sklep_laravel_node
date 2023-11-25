<?php

namespace App\Enums;

class UserRole
{

    const ADMINISTRATOR = 'administrator';
    const OPERATOR = 'operator';

    const TYPES = [
        self::ADMINISTRATOR,
        self::OPERATOR,
    ];
}
