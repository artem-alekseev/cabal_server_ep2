<?php

namespace App\Models\Dictionaries;

use Dictionaries\Dictionary;

class CharacterNationDictionary extends Dictionary
{
    const NONE = 0;
    const PROCYON = 1;
    const CAPELLA = 2;
    const GM = 3;
    /**
     * @inheritDoc
     */
    public static function getDictionary(): array
    {
        return [
            self::NONE => 'None',
            self::PROCYON => "Procyon",
            self::CAPELLA => "Capella",
            self::GM => "GM",
        ];
    }
}
