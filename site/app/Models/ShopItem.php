<?php

namespace App\Models;

use App\Models\Dictionaries\CashShopCategoriesDictionary;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    use HasFactory;

    protected $table = 'dbo.ShopItems';

    protected $primaryKey = 'Id';

    protected $connection = 'cabalcash';

    public $timestamps = false;

    public $fillable = [
        'Name',
        'Description',
        'ItemIdx',
        'DurationIdx',
        'ItemOpt',
        'Image',
        'Honour',
        'Alz',
        'Category',
        'Available',
    ];

    protected function categoryName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => CashShopCategoriesDictionary::getValueData($this->Category),
        );
    }
}
