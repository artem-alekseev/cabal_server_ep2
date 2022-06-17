<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
            get: function ($value) {
                $data = bin2hex($value);
                $skills = collect($data ? str_split($data, 8) : []);

                $skills = $skills->mapWithKeys(function ($skill, $key) {
                    $skill = new Skill($skill);

                    return [$skill->dec_position => $skill];
                });

                return $skills;
            },
            set: function ($items) {
                $items = implode('', $items->toArray());

                return DB::raw("CONVERT(VARBINARY(MAX), '0x$items', 1)");
            },
        );
    }
}
