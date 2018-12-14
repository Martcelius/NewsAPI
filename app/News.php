<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'penulis', 'title', 'body', 'thumbnail', 'status',
    ];

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }
}
