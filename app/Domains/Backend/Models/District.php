<?php

namespace App\Domains\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = 'districts';
    protected $fillable =[
        "name_kh", "name_en", "code", "active", "write_uid","province_id"
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function commune()
    {
        return  $this->hasMany(Commune::class,'district_id');
    }

}
