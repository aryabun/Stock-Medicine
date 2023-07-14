<?php

namespace App\Domains\Backend\Http\Controllers;
use App\Domains\Backend\Models\ScreeningData;
use App\Domains\Internal\Models\Pricription;




use App\Domains\Internal\Resources\InternalAdminCollection;
use App\Traits\IssueTokenTrait;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class ScreeningDataApiController
{
    public function index()
    {
   
    $screening_datas=ScreeningData::orderBy('id','DESC')->get();

      foreach($screening_datas as $screening_data)
      {
        $screening_data->prescription;
      }

      return response()->json($screening_datas);
     
    }
    public function store(Request $request)
    {
        
        $request -> validate ([
          'height' => 'required',
          'waist_circumference' => 'required',
          'weight' => 'required',
          'bmi' => 'required',
          'bls_fasting' => 'required',
          'bls_random' => 'required',
          'blp_sytolic' => 'required',
          'blp_diastolic' => 'required',
          'pulse_heart' => 'required',
          'HbA1c' => 'required',
          'keton' => 'required',
          'proteinuria' => 'required',
          'cholesterol' => 'required',
          'tobacco' => 'required',
          'high_blp' => 'required',
          'diabete' => 'required',
          'patient_id' => 'required',

        ]);
        $data = array(
          'height'=> $request ->height,
          'waist_circumference' => $request ->waist_circumference,
          'weight' =>  $request ->weight,
          'bmi' =>  $request ->bmi,
          'bls_fasting' =>  $request ->bls_fasting,
          'bls_random' =>  $request ->bls_random,
          'blp_sytolic' =>  $request ->blp_sytolic,
          'blp_diastolic' =>  $request ->blp_diastolic,
          'pulse_heart' =>  $request ->pulse_heart,
          'HbA1c' =>  $request ->HbA1c,
          'keton' =>  $request ->keton,
          'proteinuria' =>  $request ->proteinuria,
          'cholesterol' =>  $request ->cholesterol,
          'tobacco' =>  $request ->tobacco,
          'high_blp' =>  $request ->high_blp,
          'diabete' =>  $request ->diabete,
          'patient_id' => $request ->patient_id,
        );

        $screening = ScreeningData::create($data);
        return response()->json(
          [
              'data' => json_decode(
                $screening
              )
          ], 200);
    }
    public function update(Request $request,$id)
    {
      
      $request -> validate ([
        'height' => 'required',
        'waist_circumference' => 'required',
        'weight' => 'required',
        'bmi' => 'required',
        'bls_fasting' => 'required',
        'bls_random' => 'required',
        'blp_sytolic' => 'required',
        'blp_diastolic' => 'required',
        'pulse_heart' => 'required',
        'HbA1c' => 'required',
        'keton' => 'required',
        'proteinuria' => 'required',
        'cholesterol' => 'required',
        'tobacco' => 'required',
        'high_blp' => 'required',
        'diabete' => 'required',
        'patient_id' => 'required',

      ]);
      $data = array(
        'height'=> $request ->height,
        'waist_circumference' => $request ->waist_circumference,
        'weight' =>  $request ->weight,
        'bmi' =>  $request ->bmi,
        'bls_fasting' =>  $request ->bls_fasting,
        'bls_random' =>  $request ->bls_random,
        'blp_sytolic' =>  $request ->blp_sytolic,
        'blp_diastolic' =>  $request ->blp_diastolic,
        'pulse_heart' =>  $request ->pulse_heart,
        'HbA1c' =>  $request ->HbA1c,
        'keton' =>  $request ->keton,
        'proteinuria' =>  $request ->proteinuria,
        'cholesterol' =>  $request ->cholesterol,
        'tobacco' =>  $request ->tobacco,
        'high_blp' =>  $request ->high_blp,
        'diabete' =>  $request ->diabete,
        'patient_id' => $request ->patient_id,
      );
      
      ScreeningData::where('id',$id)->update($data);
      return response()->json([
          'status' => 'success',
           'data'=>$data]);

    }

    public function destroy($id)
    {
      $screening = ScreeningData::find($id);
      $screening->delete();
      return response()->json(
        [   'status' => 'Success',
            'data' => json_decode(
              $screening
                )
         ], 200);
    }
    
    
}