<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\External\Models\ExternalAdmin;
use App\Domains\Internal\Models\InternalAdmin;

class WarehouseOwnersController
{
    //
    public function getUser()
    {
        # code...
        $a = ExternalAdmin::select(
                    'code','first_name_en','first_name_km','last_name_en','last_name_km',
                )->get();
        $b = InternalAdmin::select(
            'code','first_name_en','first_name_km','last_name_en','last_name_km',
        )->get();
        $result = $a->crossJoin($b);
        
        // foreach($result as $results){
        // }
        // AllUser::create($result);
        return response()->json($result);
    }

}
