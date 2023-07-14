<?php

namespace App\Domains\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LifeStyle extends Model
{
    use HasFactory;
    protected $table = 'life_styles';
    protected $fillable=[
        "smoking","exercise" ,"alcohol","patient_id"
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }
}
