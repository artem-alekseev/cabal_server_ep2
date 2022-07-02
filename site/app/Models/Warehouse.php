<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'dbo.cabal_warehouse_table';

    protected $primaryKey = 'UserNum';

    protected $connection = 'gamedb';

    public $timestamps = false;

    public $fillable = [
        'UserNum',
        'Alz',
    ];
}
