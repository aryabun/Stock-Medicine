<?php

namespace App\Domains\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;
    protected $table = 'communes';
    protected $fillable = [
        "name_kh","name_en","code","gis_code","create_uid",
        "write_id","district_id"
    ];

    public function district()
    {
       return $this->belongsTo(District::class);
    }
    public function village()
    {
        return $this->hasMany(Village::class,'commune_id');
    }
}
