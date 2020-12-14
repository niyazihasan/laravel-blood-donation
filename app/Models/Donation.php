<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $guarded = [];

    const CHECKED = 1;
    const USED = 2;

    const RESULT_NEGATIVE = 1;
    const RESULT_POSITIVE = 2;

    public $results = [
        null => 'Изс. не е готово',
        self::RESULT_NEGATIVE => '(-) Отрицателен',
        self::RESULT_POSITIVE => '(+) Положителен'
    ];

    public function laborant()
    {
        return $this->belongsTo(User::class, 'laborant_id');
    }

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function donorDeclaration()
    {
        return $this->belongsTo(DonorDeclaration::class, 'donor_declaration_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    protected function getHepatitisBAttribute($param)
    {
        return $this->results[$param];
    }

    protected function getHepatitisCAttribute($param)
    {
        return $this->results[$param];
    }

    protected function getSyphilisAttribute($param)
    {
        return $this->results[$param];
    }

    protected function getHivSpinAttribute($param)
    {
        return $this->results[$param];
    }

}
