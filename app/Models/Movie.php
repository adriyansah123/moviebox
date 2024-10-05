<?php

namespace App\Models;

use App\Models\Episode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'description',
        'genre',
        'release_date',
        'thumbnail',
        'video_url',
    ];

    public function episode()
    {
        return $this->hasMany(Episode::class, 'movie_id');
    }
}
