<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Premium extends Model
{
    use HasFactory;

    protected $table = 'dbo.cabal_charge_auth';

    protected $primaryKey = 'UserNum';

    protected $connection = 'account';

    public $timestamps = false;

    public $fillable = [
        'ExpireDate'
    ];

    public $casts = [
        'ExpireDate' => 'datetime'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'UserNum', 'UserNum');
    }
}
