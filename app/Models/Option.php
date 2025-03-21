<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //クイズと紐付け
    public function quiz()
    {
        return $this->belognsTo(Quiz::class);
    }
}
