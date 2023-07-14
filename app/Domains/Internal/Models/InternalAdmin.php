<?php
namespace App\Domains\Internal\Models;

use App\Domains\Auth\Models\Traits\Attribute\UserAttribute;
use App\Domains\Auth\Models\Traits\Method\UserMethod;
use App\Domains\Auth\Models\Traits\Relationship\UserRelationship;
use App\Domains\Auth\Models\Traits\Scope\UserScope;
use App\Models\Enumeration\SettingEnum;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class InternalAdmin extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,
        HasFactory,
        HasRoles,
        MustVerifyEmailTrait,
        Notifiable,
        SoftDeletes,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope,
        Impersonate;


    protected $table = 'internal_admins';
    protected string $guard_name = SettingEnum::TYPE_INTERNAL_ADMIN;

    protected $fillable = [
        'code',
        'first_name_en',
        'first_name_km',
        'last_name_en',
        'last_name_km',
        'access_token',
        'phone_number',
        'email',
        'gender',
        'dob',
        'profile',
        'personal_code',
        'nbf',
        'exp',
        'iat',
        'jti',
        'active',
        'created_at,updated_at,deleted_at',
        'email_verified_at',
        'password',
        'password_changed_at',
        'active',
        'timezone',
        'last_login_at',
        'last_login_ip',
        'to_be_logged_out',
        'provider',
        'provider_id',
    ];
    protected $with = [
        'permissions',
        'roles',
    ];
    protected $casts = [
        'active' => 'boolean',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'to_be_logged_out' => 'boolean',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $dates = [
        'last_login_at',
        'email_verified_at',
        'password_changed_at',
    ];
    public function receivesBroadcastNotificationsOn()
    {
        return 'users.notification.'.$this->code;
    }

}
