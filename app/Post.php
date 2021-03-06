<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        "title",
        "content",
        "author_name",
        "author_email"
    ];

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }
}
