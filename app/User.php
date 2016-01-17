<?php

namespace App;

use App\Models\ConfirmationToken;
use App\Models\DifficultyUser;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'frequency', 'confirmed'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function confirmationToken()
    {
        return $this->hasOne(ConfirmationToken::class);
    }

    public function difficulties()
    {
        return $this->hasMany(DifficultyUser::class);
    }

    public function setAsConfirmedUser()
    {
        $this->confirmed = true;
        $this->save();
    }
}
