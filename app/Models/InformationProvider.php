<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformationProvider extends Model
{
    protected $fillable = [
        'name',
        'relation_to_hr',
        'ethinic_group',
        'mother_tongue',
        'religion',
        'created_by'
    ];
}
