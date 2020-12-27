<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * @package App\Models
 */
class Question extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded= [];

    const TYPE_OPEN = 1;
    const TYPE_CLOSED = 2;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function declaration()
    {
        return $this->belongsTo(Declaration::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
