<?php
 
namespace App\Hashing;
 
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Hashing\AbstractHasher;
use Illuminate\Support\Facades\DB;

class Md5Hasher extends AbstractHasher implements Hasher
{
    public function make($value, array $options = []): string
    {
        return DB::selectOne("select dbo.fn_md5('$value') as password")->password;
    }
 
    public function check($value, $hashedValue, array $options = []): bool
    {
        return $this->make($value) === $hashedValue;
    }
 
    public function needsRehash($hashedValue, array $options = []): bool
    {
        return false;
    }
}