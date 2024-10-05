<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    protected $fillable = [
        'movie_id',
        'season',
        'episode',
        'file',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class); // Relasi dengan model Movie
    }
}
