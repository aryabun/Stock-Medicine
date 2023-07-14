<?php

namespace App\Domains\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $table = 'provinces';
    protected $fillable =[
        "name_kh", "name_en", "code", "active", "write_uid"
    ];
    public function district()
    {
        return $this->hasMany(District::class,'province_id');
    }
    public function operationalDistrict()
    {
        return $this->hasMany(OperationalDistrict::class,'province_id');
    }
}
