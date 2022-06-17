<?php

namespace App\Models\Dictionaries;

use Dictionaries\Dictionary;

class PremiumTypeDictionary extends Dictionary
{
    const FREE = 0;
    const BRONZE = 1;
    const SILVER = 2;
    const GOLD = 3;
    const PLATINUM = 4;
    const DIAMOND = 5;

    /**
     * @inheritDoc
     */
    public static function getDictionary(): array
    {
        return [
            self::FREE =>  'FREE',
            self::BRONZE => 'Premium Service Bronze',
            self::SILVER => 'Premium Service Silver',
            self::GOLD => 'Premium Service Gold',
            self::PLATINUM => 'Premium Service Platinum',
            self::DIAMOND => 'Premium Service Diamond',
        ];
    }
}
