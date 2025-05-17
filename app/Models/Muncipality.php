<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Muncipality extends Model
{
    protected $fillable = ['name', 'code', 'district_id', 'no_of_wards'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
