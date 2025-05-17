<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class DistrictUser extends User
{
    protected $guarded = [];

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('district', function (Builder $builder) {
            $builder->whereHas('user', function ($query) {
                $query->role('district');
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
