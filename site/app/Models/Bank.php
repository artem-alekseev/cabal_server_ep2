<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'dbo.Bank';

    protected $primaryKey = 'UserNum';

    protected $connection = 'cabalcash';

    public $timestamps = false;

    public $fillable = [
        'UserNum',
        'Alz',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
