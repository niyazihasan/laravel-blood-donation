<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Declaration
 * @package App\Models
 */
class Declaration extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = [];

    const ACTIVE = 1;
    const INACTIVE = 0;

    const ACTIVES = [
        self::ACTIVE, self::INACTIVE
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * @param Question $question
     */
    public function addQuestion(Question $question)
    {
        $this->questions()->save($question);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active === self::ACTIVE;
    }

    /**
     * @return int
     */
    public function toogleActive()
    {
        return $this->isActive() ? self::INACTIVE : self::ACTIVE;
    }
}
