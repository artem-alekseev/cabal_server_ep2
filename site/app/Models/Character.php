<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Character extends Model
{
    use HasFactory;

    protected $table = 'dbo.cabal_character_table';

    protected $primaryKey = 'CharacterIdx';

    protected $connection = 'gamedb';

    public $timestamps = false;

    public $fillable = [
        'Name',
        'LEV',
        'STR',
        'DEX',
        'INT',
        'Alz',
        'Nation',
    ];

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class, 'CharacterIdx', 'CharacterIdx');
    }

    public function skillList(): HasOne
    {
        return $this->hasOne(SkillList::class, 'CharacterIdx', 'CharacterIdx');
    }
}
