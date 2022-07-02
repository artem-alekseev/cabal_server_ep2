<?php

namespace App\Models\Dictionaries;

use Dictionaries\Dictionary;

class CashShopCategoriesDictionary extends Dictionary
{
    public const COSTUMES = 1;
    public const GEAR = 2;
    public const PETS = 3;
    public const USABLES = 4;
    public const ITEMS = 5;

    public static function getDictionary(): array
    {
        return [
            self::COSTUMES => 'Costumes',
            self::GEAR => 'Gear',
            self::PETS => 'Pets',
            self::USABLES => 'Usables',
            self::ITEMS => 'Items',
        ];
    }
}
