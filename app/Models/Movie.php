<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function link() {
        return $this->belongsTo('App\Models\Link');
    }

    protected $fillable = [
        'link_id', 'movie_id'
    ];
}
