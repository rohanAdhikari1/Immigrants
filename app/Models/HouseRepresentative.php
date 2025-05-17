<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseRepresentative extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'contact_no',
        'occupation',
        'address',
        'family_memeber_count',
        'family_members_male_count',
        'family_members_female_count',
        'family_members_other_count',
        'family_migration_count',
        'family_members_migration_male_count',
        'family_members_migration_female_count',
        'family_members_migration_other_count',
        'muncipality_id',
        'ward_no',
        'address_1',
        'address_2',
        'house_no',
    ];
}
