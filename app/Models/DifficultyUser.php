<?php namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class DifficultyUser extends Model
{
    protected $table = 'difficulty_users';

    protected $fillable = [
        'difficulty_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }
}
