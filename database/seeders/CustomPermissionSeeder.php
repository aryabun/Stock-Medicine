<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Domains\Ministry\Models\MinistryOfficer;
use App\Models\Enumeration\ModelEnum;
use App\Models\Enumeration\SettingEnum;
use Illuminate\Database\Seeder;


class CustomPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Registering Roles
         */
        $roles = Role::all()->toArray();
        $customPermissions = $this->generate_permission($roles);
        $allPermissions = Permission::all()->keyBy('name');
        foreach ($customPermissions as $customPermission) {
            $this->registerPermission($customPermission, $allPermissions, null);
        }
        $externalPermissions = Permission::where('guard_name', SettingEnum::TYPE_EXTERNAL_ADMIN)->pluck('id')->toArray();
        $internalPermissions = Permission::where('guard_name', SettingEnum::TYPE_INTERNAL_ADMIN)->pluck('id')->toArray();
        $roleExternalAdmin = Role::where('type', SettingEnum::TYPE_EXTERNAL_ADMIN)
            ->where('name', config('boilerplate.access.role.external_admin'))
            ->first();
        $roleInternalAdmin = Role::where('type', SettingEnum::TYPE_INTERNAL_ADMIN)
            ->where('name', config('boilerplate.access.role.internal_admin'))
            ->first();
        $roleExternalAdmin->givePermissionTo($externalPermissions);
        $roleInternalAdmin->givePermissionTo($internalPermissions);
    }

    function registerPermission($permission, $existingPermissions, $parentId): Permission
    {
        if (!isset($existingPermissions[$permission['name']])) {
            // register new permission
            $newPermission = new Permission();
            $newPermission->guard_name = $permission['guard_name'];
            $newPermission->type = $permission['type'];
            $newPermission->name = $permission['name'];
            $newPermission->description = $permission['description'];
            $newPermission->parent_id = $parentId;
            $newPermission->save();
            if (isset($permission['children'])) {
                $childrenPermissions = $permission['children'];
                foreach ($childrenPermissions as $childrenPermission) {
                    $this->registerPermission($childrenPermission, $existingPermissions, $newPermission->id);
                }
            }
        } else {
            if (isset($permission['children'])) {
                $childrenPermissions = $permission['children'];
                foreach ($childrenPermissions as $childrenPermission) {
                    $this->registerPermission($childrenPermission, $existingPermissions, $existingPermissions[$permission['name']]->id);
                }
            }
            $newPermission = $existingPermissions[$permission['name']];
        }
        return $newPermission;
    }

    function generate_permission($roles): array
    {

        $output = [];
        $cans = [
            'create',
            'view',
            'list',
            'update',
            'delete',
            'import',
            'export',
            'print',
        ];
        $models = ModelEnum::MODEL_PROP;
        foreach ($models as $model) {

            foreach (SettingEnum::GUARDS as $guard) {
                $tmp = [
                    'guard_name' => $guard,
                    'type' => $guard,
                    'name' => 'access.' . strtolower($model['name']),
                    'description' => 'All ' . $model['name'] . ' Permissions',
                ];
                foreach ($cans as $can) {
                    $children = [
                        'guard_name' => $guard,
                        'type' => $guard,
                        'name' => $tmp['name'] . '.' . $can,
                        'description' => strtoupper($can) . ' ' . $model['name'],
                    ];
                    $tmp['children'][] = $children;
                }
                $output[] = $tmp;
            }
        }
        return $output;
    }
}
