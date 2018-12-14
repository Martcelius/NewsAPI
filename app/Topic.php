<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'topic',
    ];

    public function news()
    {
        return $this->belongsToMany(News::class);
    }
}
