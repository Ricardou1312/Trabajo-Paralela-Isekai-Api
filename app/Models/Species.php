<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    protected $table = 'isekai.species';
    public $timestamps = false;
    protected $fillable = ['code', 'name'];
}
