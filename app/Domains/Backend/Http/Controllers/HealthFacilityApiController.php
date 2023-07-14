<?php

namespace App\Domains\Backend\Http\Controllers;

use App\Domains\Backend\Models\HealthFacility;
use App\Domains\Backend\Models\Province;
use App\Domains\Backend\Models\District;
use App\Domains\Backend\Models\Commune;
use App\Domains\Backend\Models\Village;
use App\Domains\Backend\Models\OperationalDistrict;
use Illuminate\Http\Request;

class HealthFacilityApiController
{

    public function province(Request $request)
    {
            $province=Province::select('id','name_kh','name_en')
            ->get();
        return response()->json(
            [
                'data' => json_decode(
                    $province
                )
            ], 200);
    }
    public function district(Request $request)
    {
   
        $data['districts'] = District::where('province_id',$request->province_id)->get(['id','name_kh']);
        return response()->json($data);
    }
    public function commune(Request $request)
    {
    $data['communes'] = Commune::where('district_id',$request->district_id)->get(['id','name_kh']);
        return response()->json($data);
    }

    public function village(Request $request)
    {
        $data['villages'] =Village::where('commune_id',$request->commune_id)->get(['id','name_kh']);
        return response()->json($data);
    }

    public function operationalDistrict(Request $request)
    {
  
        $data['operational_district'] = OperationalDistrict::select('id','name_kh')->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate ([
            'postal_code'=>'required',
            'name_kh'    => 'required',
            'name_en'    => 'required',
            'level'      => 'required',
            'od'         => 'required',
            'p_code'     => 'required',
            'd_code'     => 'required',
            'c_code'     => 'required',
            'v_code'     => 'required',
            
        ]);
        $data = [
            'postal_code'=>$request->postal_code,
            'name_kh'=>$request->name_kh,
            'name_en'=>$request->name_en,
            'level'=> $request->level,
            'od'=> $request->od,
            'p_code'=>$request->p_code,
            'd_code' => $request->d_code,
            'c_code'=>$request->c_code,
            'v_code' => $request->v_code,
            
        ];
        $health_facility = HealthFacility::create($data);
        return response()->json(
            [
                'data' => json_decode(
                    $health_facility
                )
            ], 200);
    }

    public function index(Request $request)
    {
        if($request->has('id')){
            $health_ficilities = HealthFacility::where('id', $request->id)
            ->get();
        }else{
            $health_ficilities = HealthFacility::all();
        }
        return response()->json($health_ficilities);

    }

    public function update(Request $request,$id)
    {
       
        $request->validate ([
            'postal_code'=>'required',
            'name_kh'    => 'required',
            'name_en'    => 'required',
            'level'      => 'required',
            'od'         => 'required',
            'p_code'     => 'required',
            'd_code'     => 'required',
            'c_code'     => 'required',
            'v_code'     => 'required',
            
        ]);
        $data = [
            'postal_code'=>$request->postal_code,
            'name_kh'=>$request->name_kh,
            'name_en'=>$request->name_en,
            'level'=> $request->level,
            'od'=> $request->od,
            'p_code'=>$request->p_code,
            'd_code' => $request->d_code,
            'c_code'=>$request->c_code,
            'v_code' => $request->v_code,
            
        ];
         HealthFacility::where('id', $id)->update($data);

   
    return response()->json(['data'=>$data],
                            200);
    }

    public function destroy($id)
    {
        $health_facility = HealthFacility::find($id);
        $health_facility->delete();
        return response()->json(
            [
                'data' => json_decode(
                    $health_facility
                    )
             ], 200);

    }

}