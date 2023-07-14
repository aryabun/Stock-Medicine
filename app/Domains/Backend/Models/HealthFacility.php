<?php

namespace App\Domains\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthFacility extends Model
{
    use HasFactory;
    protected $table = 'health_facilities';
    protected $fillable =[
        "postal_code", "name_kh", "name_en", "prefix", "prefix_code"
        ,"level","od","address" , "p_code" ,"d_code", "c_code" ,"v_code"
    ];

}
