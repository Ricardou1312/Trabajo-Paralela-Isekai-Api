<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
     protected $table = 'isekai.persons';
    public $timestamps = false;

    protected $fillable = [
        'id', 'name', 'gender_code', 'species_code', 'stratum_code'
    ];
}
