<?php

namespace App\Domains\Backend\Http\Controllers;

use App\Domains\Backend\Models\Patient;
use App\Domains\Internal\Models\Test;
use App\Domains\Internal\Models\Province;
use App\Domains\Internal\Models\District;
use App\Domains\Internal\Resources\InternalAdminCollection;
use App\Traits\IssueTokenTrait;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;


class PatientController
{
    public function index()
    {
        $patients=Patient::orderBy('id','DESC')->get();
        return response()->json(
            [
                'data' => json_decode(
                    $patients
                )
            ], 200);
    }
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'phone' => 'required',
            'name'  => 'required',
            'dob'   => 'required',
            'gender'=> 'required',
            'marital_status' => 'required',
            'province'      => 'required',
            'district' => 'required',
            'commune' => 'requrired',
            'village' => 'required',
            'operational_district' => 'required',
        ]);
        $data = array(
            'phone'=> $request->phone,
            'name'=> $request->name, 
            'dob'=> $request->dob, 
            'gender'=> $request->gender, 
            'marital_status'=> $request->marital_status, 
            'province'=> $request->province, 
            'district'=> $request->district, 
            'commune'=> $request->commune, 
            'village'=> $request->village, 
            'operational_district'=> $request->operational_district, 
        );
        
       
       $patient = Patient::create($data);
        return response()->json(
            [
                'data' => json_decode(
                    $patient
                )
            ], 200);
    
    }
  
    public function show($id) 
    {
    
    }   
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'phone' => 'required',
            'name'  => 'required',
            'dob'   => 'required',
            'gender'=> 'required',
            'marital_status' => 'required',
            'province'      => 'required',
            'district' => 'required',
            'commune' => 'requrired',
            'village' => 'required',
            'operational_district' => 'required',
        ]);

        $data = array(
            'phone'=> $request->phone,
            'name'=> $request->name, 
            'dob'=> $request->dob, 
            'gender'=> $request->gender, 
            'marital_status'=> $request->marital_status, 
            'province'=> $request->province, 
            'district'=> $request->district, 
            'commune'=> $request->commune, 
            'village'=> $request->village, 
            'operational_district'=> $request->operational_district, 
        ); 
            Patient::where('id',$id)->update($data);

        return response()->json(['data'=>$data],200);
       
    }

    public function destroy($id)
    {
        
        $patient = Patient::find($id);
        $patient->delete();
       
        return response()->json(
            [
                'data' => json_decode($patient)
             ], 200);
    }

}