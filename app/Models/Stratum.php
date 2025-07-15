<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stratum extends Model
{
    protected $table = 'isekai.strata'; // Nombre real en la BD
    public $timestamps = false;

    protected $fillable = ['code', 'name'];
}