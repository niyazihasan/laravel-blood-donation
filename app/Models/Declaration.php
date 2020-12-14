<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Declaration extends Model
{
    use HasFactory;

    protected $guarded = [];

    const ACTIVE = 1;
    const INACTIVE = 0;

    const ACTIVES = [
        self::ACTIVE, self::INACTIVE
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function addQuestion(Question $question)
    {
        $this->questions()->save($question);
    }

    public function isActive()
    {
        return $this->active === self::ACTIVE;
    }

    public function toogleActive()
    {
        return $this->isActive() ? self::INACTIVE : self::ACTIVE;
    }
}
