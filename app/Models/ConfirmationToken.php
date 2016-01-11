<?php namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ConfirmationToken extends Model
{
    protected $table = 'confirmation_tokens';

    protected $fillable = [
        'token', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
