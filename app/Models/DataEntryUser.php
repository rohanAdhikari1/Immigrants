<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class DataEntryUser extends User
{
    protected $guarded = [];

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('user', function (Builder $builder) {
            $builder->whereHas('user', function ($query) {
                $query->role('user');
            });
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function currentMigrantWorkers()
    {
        return $this->hasMany(CurrentMigrantWorker::class, 'created_by', 'id');
    }

    public function returnedMigrantWorkers()
    {
        return $this->hasMany(ReturnedMigrantWorker::class, 'created_by', 'id');
    }
}
