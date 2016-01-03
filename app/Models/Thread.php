<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $table = 'threads';

    protected $fillable = [
        'title', 'published_at', 'url',
        'content', 'html_content', 'difficulty'
    ];

    protected $dates = ['created_at', 'updated_at', 'published_at'];
}
