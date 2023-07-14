<?php

namespace App\Domains\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Patient extends Model
{
    use HasFactory;
    protected $table = 'patients';
    protected $fillable =[
        "phone","name","dob","gender","marital_status",
        "province","district","commune","village","operational_district",
    ];

    public function screeningData()
    {
        return $this->hasMany(ScreeningData::class);
    }
    public function prescription()
    {
        return $this->hasMany(Pricription::class);
    }
    public function lifeStyle()
    {
        return $this->hasMany(LifeStyle::class);
    }
    
}
