<?php

namespace App\Domains\External\Http\Middleware;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Models\Enumeration\SettingEnum;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Console\Seeds\SeedCommand;
use Laravel\Passport\Exceptions\MissingScopeException;

/**
 * Class RedirectIfAuthenticated.
 */
class CheckExternalAdmin
{
    public function handle($request, Closure $next)
    {
        $role = Role::where('type', SettingEnum::TYPE_EXTERNAL_ADMIN)->first();
        if (! $request->user() || ! $request->user()->token()) {
            throw new AuthenticationException;
        }
        if (!$request->user()->hasRole($role->name)) {
            return redirect(route('api.v1.external.access_denied'));
        }
        return $next($request);
    }
}
