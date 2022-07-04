<?php

namespace App\Models\Dictionaries;

use Dictionaries\Dictionary;

class CharacterNationDictionary extends Dictionary
{
    const NONE = 0;
    const CAPELLA = 1;
    const PROCYON = 2;
    const GM = 3;
    /**
     * @inheritDoc
     */
    public static function getDictionary(): array
    {
        return [
            self::NONE => 'None',
            self::CAPELLA => "Capella",
            self::PROCYON => "Procyon",
            self::GM => "GM",
        ];
    }
}
