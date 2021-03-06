<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dbo.cabal_auth_table';

    protected $primaryKey = 'UserNum';

    protected $connection = 'account';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ID',
        'Password',
        'Login',
    ];

    public $casts = [
        'CreateDate' => 'date'
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }

    protected function Password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => DB::selectOne("select dbo.fn_md5('$value') as password")->password,
        );
    }

    protected function isAdmin(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->characters()->where('Nation', 3)->exists(),
        );
    }

    public function premium(): HasOne
    {
        return $this->hasOne(Premium::class, 'UserNum', 'UserNum');
    }

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'account.dbo.user_characters', 'UserNum', 'CharacterIdx');
    }

    public function bank(): HasOne
    {
        return $this->hasOne(Bank::class, 'UserNum', 'UserNum');
    }

    public function warehouse(): HasOne
    {
        return $this->hasOne(Warehouse::class, 'UserNum', 'UserNum');
    }
}
