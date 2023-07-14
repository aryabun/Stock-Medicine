<?php

namespace App\Domains\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricription extends Model
{
    use HasFactory;
    protected $table= 'precriptions';
    protected $fillable = [
        "medicine" , "usage" , "type" , "quantity" , "aday_quantity",
        "number_day" , "total_medicine" , "note" , "patient_id" ,"screening_id"
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function screeningData()
    {
        return $this->belongsTo(ScreeningData::class,'screening_id');
    }

}
