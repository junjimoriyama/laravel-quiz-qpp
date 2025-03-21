<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Options;

class Quiz extends Model
{
    //レベルと紐付け
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // 選択肢と紐付け
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
