<?php

namespace App\Domains\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalDistrict extends Model
{
    use HasFactory;
    protected $table = "operational_districts";
    protected  $fillable = [
        "id", "name_kh", "name_en","code" , "active" , "write_uid" , "province_id"
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
