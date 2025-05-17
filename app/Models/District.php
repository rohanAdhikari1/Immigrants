<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['name', 'code'];

    public function muncipalities()
    {
        return $this->hasMany(Muncipality::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
