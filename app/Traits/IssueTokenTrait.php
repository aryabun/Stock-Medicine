<?php

namespace App\Traits;
use App\Models\Enumeration\SettingEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
trait IssueTokenTrait
{

    public function issueInternalAdminToken($prop, $grantType, string $scope = SettingEnum::TYPE_INTERNAL_ADMIN)
    {
        $request = new Request();
        return app()->handle($request->create('oauth/token', 'POST', [
            'grant_type' => $grantType,
            'client_id' => config('passport.personal_internal_admin_access_client.id'),
            'client_secret' => config('passport.personal_internal_admin_access_client.secret'),
            'username' => $prop['email'],
            'password' => $prop['password'],
            'scope' => $scope,
        ]))->getContent();
    }

    public function issueExternalAdminToken($prop, $grantType, string $scope = SettingEnum::TYPE_EXTERNAL_ADMIN)
    {
        $request = new Request();
        return app()->handle($request->create('oauth/token', 'POST', [
            'grant_type' => $grantType,
            'client_id' => config('passport.personal_external_admin_access_client.id'),
            'client_secret' => config('passport.personal_external_admin_access_client.secret'),
            'username' => $prop['email'],
            'password' => $prop['password'],
            'scope' => $scope,
        ]))->getContent();
    }

    public function refreshInternalAdminToken(Request $request, $grantType, string $scope = SettingEnum::TYPE_INTERNAL_ADMIN)
    {
        $res = app()->handle($request->create('oauth/token', 'POST', [
            'grant_type' => $grantType,
            'client_id' => config('passport.personal_internal_admin_access_client.id'),
            'client_secret' => config('passport.personal_internal_admin_access_client.secret'),
            'refresh_token' => $request->refresh_token,
            'scope' => $scope,
        ]));
        if ($res->getStatusCode() == 200 || $res->getStatusCode() == 201) {
            return $res->getContent();
        } else {
            return response()->json(
                ['message', 'Something went wrong. please re-login'],
                422);
        }
    }

    public function refreshExternalAdminToken(Request $request, $grantType, string $scope = SettingEnum::TYPE_EXTERNAL_ADMIN)
    {
        $res = app()->handle($request->create('oauth/token', 'POST', [
            'grant_type' => $grantType,
            'client_id' => config('passport.personal_external_admin_access_client.id'),
            'client_secret' => config('passport.personal_external_admin_access_client.secret'),
            'refresh_token' => $request->refresh_token,
            'scope' => $scope,
        ]));
        if ($res->getStatusCode() == 200 || $res->getStatusCode() == 201) {
            return $res->getContent();
        } else {
            return response()->json(
                ['message', 'Something went wrong. please re-login'],
                422);
        }
    }

}
