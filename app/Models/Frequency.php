<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    protected $table = 'frequencies';

    protected $fillable = [
        'short_name', 'name'
    ];

    public $timestamps = false;
}
