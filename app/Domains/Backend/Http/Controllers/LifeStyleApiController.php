<?php

namespace App\Domains\Backend\Http\Controllers;

use App\Domains\Backend\Models\LifeStyle;
use Illuminate\Http\Request;


class LifeStyleApiController
{
    public function index()
    {
        $life_styles=LifeStyle::first();
        return response()->json(
            [
                'data' => json_decode(
                    $life_styles
                )
            ], 200);
    }
    public function store(Request $request)
    {
        $request->validate ([
            'smoking'=>'required',
            'exercise'=>'required',
            'alcohol'=>'required',

        ]);
        $data = array(

        'smoking'=>$request->smoking,
        'exercise'=>$request->exercise == 'on' ? 1 : 0,
        'alcohol'=>$request->alcohol == 'on' ? 1 : 0,
        );
         
    
       $life_style= LifeStyle::create($data);
       return response()->json(
        [
            'data' => json_decode(
                $life_style
            )
        ], 200);
    }

    public function update(Request $request,$id)
    {
       
        $request->validate ([
            'smoking'=>'required',
            'exercise'=>'required',
            'alcohol'=>'required',

        ]);
       
        $data = array(
        'smoking'=>$request->smoking,
        'exercise'=>$request->exercise == 'on' ? 1 : 0,
        'alcohol'=>$request->alcohol == 'on' ? 1 : 0,
        );

        LifeStyle::where('id',$id)->update($data);
        
        return response()->json([
            'status' => 'Success',
            'data'=>$data],200);

    }
    public function destroy($id)
    {
        $life_style =LifeStyle::find($id);
        $life_style->delete();
        return response()->json(
            [
                'status' => 'Success',
                'msg' => 'Delete successful'
            ], 200);
    }


    
}