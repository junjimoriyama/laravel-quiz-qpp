<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    //
    protected $fillable = ['key', 'label'];

    // クイズと紐付け
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function record()
    {
        return $this->hasMany(Record::class);
    }
}
