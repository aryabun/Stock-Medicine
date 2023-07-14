<?php

namespace App\Domains\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $table= 'villages';
    protected $fillable = [
        "name_kh","name_en","code","gis_code","create_uid",
        "write_id","commune_id"
    ];
    public function commune()
    {
        return $this->belongsTo(Commune::class);
        
    }
}
