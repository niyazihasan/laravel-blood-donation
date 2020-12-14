<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DateTime;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $hidden = ['password', 'remember_token',];

    protected $casts = ['email_verified_at' => 'datetime',];

    public $bloodTypes = [
        null => '-избери-',
        1 => 'A(+)', 2 => 'B(+)', 3 => 'AB(+)', 4 => 'O(+)',
        5 => 'A(-)', 6 => 'B(-)', 7 => 'AB(-)', 8 => 'O(-)'
    ];

    protected $guarded = [];

    protected $appends = ['blood_group'];

    const ACTIVE = 1;
    const INACTIVE = 0;

    const ROLE_USER = 'ROLE_USER';
    const ROLE_PATIENT = 'ROLE_PATIENT';
    const ROLE_DOCTOR = 'ROLE_DOCTOR';
    const ROLE_LABORANT = 'ROLE_LABORANT';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SUPERDOCTOR = 'ROLE_SUPERDOCTOR';

    public $roles = [
        self::ROLE_USER => 'Донор',
        self::ROLE_ADMIN => 'Администратор',
        self::ROLE_DOCTOR => 'Доктор на болница',
        self::ROLE_LABORANT => 'Лаборант',
        self::ROLE_SUPERDOCTOR => 'Доктор на кръводарителен център'
    ];

    protected function getAgeAttribute()
    {
        try {
            $egn = $this->egn;
            $month = (int)substr($egn, 2, 2);
            $year = (int)substr($egn, 0, 2);
            $day = (int)substr($egn, 4, 2);
            if ($month > 40) {
                $month -= 40;
                $year += 2000;
            } else if ($month > 20) {
                $month -= 20;
                $year += 1800;
            } else {
                $year += 1900;
            }
            $birthdayDate = new DateTime("$year-$month-$day");
            $nowDate = new DateTime();
            $diff = $nowDate->diff($birthdayDate);
            return (int)$diff->y;
        } catch (\Exception $e) {
            return 'Невалидно ЕГН!';
        }
    }

    public function isActive()
    {
        return $this->active === self::ACTIVE;
    }

    protected function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    protected function getGenderAttribute()
    {
        $num9 = $this->egn[8];
        $gender = '';
        if (in_array($num9, [0, 2, 4, 6, 8])) {
            $gender = 'мъж';
        } else if (in_array($num9, [1, 3, 5, 7, 9])) {
            $gender = 'жена';
        } else {
            $gender = 'невалиден';
        }
        return $gender;
    }

    protected function getCurrentNeedBloodAttribute()
    {
        return $this->blood_quantity - $this->current_blood;
    }

    protected function getTypeAttribute()
    {
        return $this->roles[$this->role];
    }

    protected function getFullNameAttribute()
    {
        return "$this->name $this->fathersname $this->surname";
    }

    protected function getBloodGroupAttribute()
    {
        return $this->bloodTypes[$this->blood_type];
    }

    protected function donations()
    {
        return $this->hasMany(Donation::class, 'donor_id')
            ->whereIn('flag', [Donation::CHECKED, Donation::USED]);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    protected function donors()
    {
        return $this->hasMany(Donation::class, 'patient_id')
            ->where([
                'hepatitis_c' => Donation::RESULT_NEGATIVE,
                'hiv_spin' => Donation::RESULT_NEGATIVE,
                'syphilis' => Donation::RESULT_NEGATIVE,
                'hepatitis_b' => Donation::RESULT_NEGATIVE,
                'flag' => Donation::USED
            ]);
    }
}
