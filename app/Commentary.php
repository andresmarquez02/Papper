<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commentary extends Model
{
    protected $guarded = [];

    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
}
