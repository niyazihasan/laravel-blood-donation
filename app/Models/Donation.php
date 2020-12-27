<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Donation
 * @package App\Models
 */
class Donation extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = [];

    const CHECKED = 1;
    const USED = 2;

    const RESULT_NEGATIVE = 1;
    const RESULT_POSITIVE = 2;

    /**
     * @var string[]
     */
    public $results = [
        null => 'Изс. не е готово',
        self::RESULT_NEGATIVE => '(-) Отрицателен',
        self::RESULT_POSITIVE => '(+) Положителен'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function laborant()
    {
        return $this->belongsTo(User::class, 'laborant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function donorDeclaration()
    {
        return $this->belongsTo(DonorDeclaration::class, 'donor_declaration_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * @param $param
     * @return string
     */
    protected function getHepatitisBAttribute($param)
    {
        return $this->results[$param];
    }

    /**
     * @param $param
     * @return string
     */
    protected function getHepatitisCAttribute($param)
    {
        return $this->results[$param];
    }

    /**
     * @param $param
     * @return string
     */
    protected function getSyphilisAttribute($param)
    {
        return $this->results[$param];
    }

    /**
     * @param $param
     * @return string
     */
    protected function getHivSpinAttribute($param)
    {
        return $this->results[$param];
    }

}
