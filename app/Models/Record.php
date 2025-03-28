<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'user_id',
        'level_id',
        'score',
        'correct_percentage',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Level()
    {
        return $this->belongsTo(Level::class);
    }
}
