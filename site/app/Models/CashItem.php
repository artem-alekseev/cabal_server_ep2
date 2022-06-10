<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashItem extends Model
{
    use HasFactory;

    protected $table = 'dbo.MyCashItem';

    protected $primaryKey = 'TranNo';

    protected $connection = 'cabalcash';

    public $timestamps = false;

    public $fillable = [
        'UserNum',
        'TranNo',
        'ServerIdx',
        'ItemKindIdx',
        'ItemOpt',
        'DurationIdx',
    ];
}
