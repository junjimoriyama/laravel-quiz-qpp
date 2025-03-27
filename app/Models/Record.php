<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Level()
    {
        return $this->belongsTo(Level::class);
    }
}
