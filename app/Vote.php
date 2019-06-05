<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['post_id'];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
