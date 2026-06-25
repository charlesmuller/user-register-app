<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    protected $fillable = ['name', 'address', 'cpf', 'phone'];
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
