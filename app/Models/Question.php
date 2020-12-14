<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded= [];

    const TYPE_OPEN = 1;
    const TYPE_CLOSED = 2;

    protected function declaration()
    {
        return $this->belongsTo(Declaration::class);
    }

    protected function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
