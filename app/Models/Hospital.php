<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function doctors()
    {
        return $this->hasMany(User::class)
            ->where('role', User::ROLE_DOCTOR);
    }

    protected function allPatients()
    {
        return $this->hasMany(User::class)
            ->where('role', User::ROLE_PATIENT);
    }

    public function patients()
    {
        return $this->hasMany(User::class)
            ->where('role', User::ROLE_PATIENT)
            ->whereColumn('current_blood', '<', 'blood_quantity');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
