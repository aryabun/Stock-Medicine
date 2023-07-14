<?php
namespace App\Domains\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreeningData extends Model
{
    use HasFactory;
    protected $table = 'screening_datas';
    protected $fillable =[
        "height", "waist_circumference" , "weight" , "bmi" , "bls_fasting" , "bls_random",
        "blp_sytolic" ,"blp_diastolic" , "pulse_heart" , "HbA1c" ,"keton" , "proteinuria" ,
        "cholesterol" , "tobacco" , "high_blp" ,"diabete" ,"patient_id",
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function prescription()
    {
        return $this->hasMany(Pricription::class ,'screening_id');
    }
}
