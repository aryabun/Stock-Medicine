<?php

namespace App\Domains\Backend\Http\Controllers;

use App\Domains\Backend\Models\Pricription;
use App\Domains\Backend\Models\ScreeningData;

use App\Domains\Internal\Resources\InternalAdminCollection;
use App\Traits\IssueTokenTrait;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;


class PrecriptionApiController
{
    public function index()
    {
      $prescription=Pricription::get();
    //   dd($prescription->screeningData);
        // foreach( $prescription as $value){
        //     $value->screeningData;
        // }
        
      return response()->json(
        [
            'data' => json_decode(
                $prescription
            )
        ], 200);
    }

    public function store(Request $request)
    {
        $request ->validate([
            'medicine' => 'required',
            'usage' => 'required', 
            'type' => 'required', 
            'quantity' => 'required', 
            'aday_quantity' => 'required', 
            'number_day' => 'required', 
            'total_medicine' => 'required', 
            'note' => 'required', 
        ]);
        $precription=Pricription::create($request->all());
        return response()->json(
            [
                'data' => json_decode(
                    $precription
                )
            ], 200);
        
   
    }

    public function update(Request $request,$id)
    {
        $request ->validate([
            'medicine' => 'required',
            'usage' => 'required', 
            'type' => 'required', 
            'quantity' => 'required', 
            'aday_quantity' => 'required', 
            'number_day' => 'required', 
            'total_medicine' => 'required', 
            'note' => 'required', 
        ]);
        $data = array(
            'medicine'=> $request->medicine,
            'usage'=> $request->usage,
            'type'=> $request->type,
            'quantity'=> $request->quantity,
            'aday_quantity'=> $request->aday_quantity,
            'number_day'=> $request->number_day,
            'total_medicine'=> $request->total_medicine,
            'note'=> $request->note,

        );
            
        Pricription::where('id',$id)->update($data);
        return response()->json([
            'status' => 'Success',
            'data'=>$data],200);
        
    }

    public function destroy($id)
    {
        $prescription = Pricription::find($id);
        $prescription->delete();
        return response()->json
            ([
                'status' => 'Success',
                'msg' =>'delete successfully',
                
            ], 200);

    }
  
    
}