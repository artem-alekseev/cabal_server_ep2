<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'dbo.cabal_Inventory_table';

    protected $primaryKey = 'CharacterIdx';

    protected $connection = 'gamedb';

    public $timestamps = false;

    protected $fillable = ['Data'];

    protected function Data(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $data = bin2hex($value);

                $items = collect(str_split($data, 32));

                $items = $items->mapWithKeys(function ($item, $key) {
                    $item = new Item($item);

                    return [$item->dec_position => $item];
                });

                return $items;
            },
            set: function ($items) {
                $items = implode('', $items->toArray());

                return DB::raw("CONVERT(VARBINARY(MAX), '0x$items', 1)"); 
            },
        );
    }
}
