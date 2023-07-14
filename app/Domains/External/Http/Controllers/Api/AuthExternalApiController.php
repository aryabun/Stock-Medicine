<?php

namespace App\Domains\External\Http\Controllers\Api;

use App\Domains\Auth\Models\Role;
use App\Domains\External\Models\ExternalAdmin;
use App\Domains\External\Resources\ExternalAdminCollection;
use App\Domains\Internal\Resources\InternalAdminCollection;
use App\Models\Enumeration\ModelEnum;
use App\Models\Enumeration\SettingEnum;
use App\Traits\IssueTokenTrait;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthExternalApiController
{
    use IssueTokenTrait;
    protected ExternalAdmin $external;
    public function __construct(ExternalAdmin $externals) {
        $this->external = $externals;
    }

    public function register(Request $request) {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|min:4',
            'name_km' => 'required|min:4',
            'email' => 'required|string|email|max:255',
            'dob' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        return $input;
    }

    public function login( Request $request)
    {
        
        $errors = [];
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        //-------------- check if user exist-------------------------
        try {
            $user = $this->external->where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    
                    $token = $this->issueExternalAdminToken($request, 'password');
                    $token = collect(json_decode($token))->toArray();
                    if (!isset($token['error'])) {
                        $output = [
                            'user'          => ExternalAdminCollection::collection($this->external->where('email', $request->email)->get()), //collect($officer)->toArray(),
                            "expires_in"    => $token['expires_in'],
                            "access_token"  => $token['access_token'],
                            "refresh_token" => $token['refresh_token'],
                        ];
                        return response($output,200);
                    }
                    //----prepare output to api response ----
                    return response($token,400);
                } else {
                    $response = ["message" => "Password mismatch"];
                    return response($response, 422);
                }
            } else {
                $response = ["message" =>'User does not exist'];
                return response($response, 422);
            }
        } catch (ClientException $e) {
            $errors['message'] = json_decode($e->getResponse()->getBody());
            $errors['code'] = $e->getCode();
        }
        return response($errors, 422);

    }

    public function getRefreshToken(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            [
                'data' => json_decode(
                    $this->refreshExternalAdminToken($request, 'refresh_token')
                )
            ], 200);
    }
}