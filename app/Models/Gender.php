<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    
    protected $table = 'isekai.genders';
    public $timestamps = false;
    protected $fillable = ['code', 'name'];
}
