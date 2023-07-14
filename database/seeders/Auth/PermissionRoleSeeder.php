<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Models\Enumeration\SettingEnum;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $adminRole= Role::create([
            'id' => 1,
            'type' => User::TYPE_ADMIN,
            'name' => 'Administrator',
        ]);
        $userRole= Role::create([
            'id' => 2,
            'type' => User::TYPE_USER,
            'name' => 'Patient',
        ]);
        $externalRole= Role::create([
            'id' => 3,
            'type' => SettingEnum::TYPE_EXTERNAL_ADMIN,
            'name' => config('boilerplate.access.role.external_admin'),
            'guard_name' => SettingEnum::TYPE_EXTERNAL_ADMIN
        ]);
        $internalRole = Role::create([
            'id' => 4,
            'type' =>  SettingEnum::TYPE_INTERNAL_ADMIN,
            'name' => config('boilerplate.access.role.internal_admin'),
            'guard_name' => SettingEnum::TYPE_INTERNAL_ADMIN
        ]);
       
        
    
        $adminRole = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.user',
            'description' => 'All User Permissions',
        ]);
       
        $adminRole->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.list',
                'description' => 'View Users',
                'sort' => 1,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.deactivate',
                'description' => 'Deactivate Users',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.reactivate',
                'description' => 'Reactivate Users',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.clear-session',
                'description' => 'Clear User Sessions',
                'sort' => 4,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.impersonate',
                'description' => 'Impersonate Users',
                'sort' => 5,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.change-password',
                'description' => 'Change User Passwords',
                'sort' => 6,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.health-faciliy.create',
                'description' => 'Create Health Facility',
                'sort' => 7,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.health-faciliy.update',
                'description' => 'Update Health Facility',
                'sort' => 8,
            ]), 
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.health-faciliy.view',
                'description' => 'View  Health Facility',
                'sort' => 9,
            ]), 
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.health-faciliy.delete',
                'description' => 'Delete Health Facility',
                'sort' => 10,
            ]), 
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.patient.view',
                'description' => 'View  Patient',
                'sort' => 11,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.patient.create',
                'description' => 'Create Patient',
                'sort' => 12,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.patient.update',
                'description' => 'UPdate Patient',
                'sort' => 13,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.patient.delete',
                'description' => 'Delete Patient',
                'sort' => 14,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.screeningdata.create',
                'description' => 'Create ScreeingData',
                'sort' => 15,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.screeningdata.update',
                'description' => 'Update ScreeingData',
                'sort' => 16,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.screeningdata.view',
                'description' => 'View ScreeingData',
                'sort' => 17,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.screeningdata.delete',
                'description' => 'Delete ScreeingData',
                'sort' => 18,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.precription.create',
                'description' => 'Create Precription',
                'sort' => 19,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.precription.update',
                'description' => 'Update Precription',
                'sort' => 20,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.precription.view',
                'description' => 'View Precription',
                'sort' => 21,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.precription.delete',
                'description' => 'Delete Precription',
                'sort' => 22,
            ]),
          
        ]);
         $internalRole = Permission::create([
            'type' => SettingEnum::TYPE_INTERNAL_ADMIN,
            'name' => 'internal.access.user',
            'description' => 'All User Permissions',
        ]);
        // $internalRole->children()->saveMany([
        //     new Permission([
        //         'type' => SettingEnum::TYPE_INTERNAL_ADMIN,
        //         'name' => 'hello',
        //         'description' => 'hello',
        //         'sort' => 1,
        //     ]),
        //     new Permission([
        //         'type' => SettingEnum::TYPE_INTERNAL_ADMIN,
        //         'name' => 'hihi',
        //         'description' => 'hihi',
        //         'sort' => 2,
        //     ]),
        // ]);

        $adminRole->syncPermissions(Permission::all());

        $this->enableForeignKeys();
    }
}
