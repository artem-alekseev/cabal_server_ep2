<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillList extends Model
{
    use HasFactory;

    protected $table = 'dbo.cabal_skilllist_table';

    protected $primaryKey = 'CharacterIdx';

    protected $connection = 'gamedb';

    public $timestamps = false;

    protected function Data(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => unpack('S*', $value),
            set: fn ($value) => pack('S*', $value),
        );
    }
}
