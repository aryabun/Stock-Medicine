<?php

namespace App\Domains\Internal\Http\Controllers\Api;


use App\Dodamins\Models\Role;
use App\Domains\Internal\Models\InternalAdmin;
use App\Domains\Internal\Resources\InternalAdminCollection;
use App\Traits\IssueTokenTrait;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthInternalApiController
{
    use IssueTokenTrait;
    
    protected InternalAdmin $internal;
    public function __construct(InternalAdmin $internals) {
        $this->internal = $internals;
    }

    public function login(Request $request)
    {
        // dd('helloworld');
        $errors = [];
        $validator = Validator::make($request->all(), [
            'email' => '|string|email|max:255',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response(['errequiredrors'=>$validator->errors()->all()], 422);
        }
        //-------------- check if user exist-------------------------
        try {
            $user = $this->internal->where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    
                    // dd($user);
                    $token = $this->issueInternalAdminToken($request, 'password');
                    $token = collect(json_decode($token))->toArray();
                    if (!isset($token['error'])) {
                        $output = [
                            'user'          => InternalAdminCollection::collection($this->internal->where('email', $request->email)->get()), //collect($officer)->toArray(),
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
                    $this->refreshInternalAdminToken($request, 'refresh_token')
                )
            ], 200);
    }
}