<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    protected $fillable = [
        'muncipality_id',
        'ward_no',
        'toll_name',
        'toll_no',
        'house_no',
        'visit_date',
        'latitude',
        'longitude',
        'house_representative_name',
        'house_represent_gender',
        'house_represent_contact_no',
        'house_represent_occupation',
        'family_member_count',
        'family_members_male_count',
        'family_members_female_count',
        'family_members_other_count',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function migrantWorkers()
    {
        return $this->hasMany(CurrentMigrantWorker::class, 'household_id');
    }

    public function municipality()
    {
        return $this->belongsTo(Muncipality::class, 'muncipality_id');
    }
}
