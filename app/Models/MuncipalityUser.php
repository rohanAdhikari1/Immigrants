<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class MuncipalityUser extends User
{
    protected $guarded = [];

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('muncipality', function (Builder $builder) {
            $builder->whereHas('user', function ($query) {
                $query->role('Muncipality');
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
