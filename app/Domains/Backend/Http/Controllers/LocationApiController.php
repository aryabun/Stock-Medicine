<?php

namespace App\Domains\Backend\Http\Controllers;

use App\Domains\Backend\Models\Province;
use App\Domains\Backend\Models\District;
use App\Domains\Backend\Models\Commune;
use App\Domains\Backend\Models\Village;
use App\Domains\Backend\Models\OperationalDistrict;
use App\Domains\Stock_Management\Http\Resources\CommuneResource;
use App\Domains\Stock_Management\Http\Resources\DistrictResource;
use App\Domains\Stock_Management\Http\Resources\LocationResource;
use Illuminate\Http\Request;

class LocationApiController
{
    public function index(Request $request) {
        return LocationResource::collection(Province::get());
    }

    public function province(Request $request)
    {
        if($request->has('id')){
            return LocationResource::collection(Province::where('id',$request->id)->get());
        }else{
            return Province::get();
        }
       
    }
    public function district(Request $request)
    {
        if($request->has('id')){
            return DistrictResource::collection(District::where('id',$request->id)->get());
        }else{
            return District::all();
        }
    }
    public function commune(Request $request)
    {
        if($request->has('id')){
            return CommuneResource::collection(Commune::where('id',$request->id)->get());
        }else{
            return Commune::get();
        }
    }

    public function village(Request $request)
    {
        if($request->has('id')){
            return Village::where('id',$request->id)->get();
        }else{
            return Village::get();
        }
    }

    public function operationalDistrict(Request $request)
    {
  
        $data = OperationalDistrict::get();
        return response()->json($data);
    }


}