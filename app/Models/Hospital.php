<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Hospital
 * @package App\Models
 */
class Hospital extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function doctors()
    {
        return $this->hasMany(User::class)
            ->where('role', User::ROLE_DOCTOR);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function allPatients()
    {
        return $this->hasMany(User::class)
            ->where('role', User::ROLE_PATIENT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patients()
    {
        return $this->hasMany(User::class)
            ->where('role', User::ROLE_PATIENT)
            ->whereColumn('current_blood', '<', 'blood_quantity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
