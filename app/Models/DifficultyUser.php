<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DifficultyUser extends Model
{
    protected $table = 'difficulty_users';

    protected $fillable = [
        'difficulty_id', 'user_id'
    ];
}
