<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Domains\External\Models\ExternalAdmin;
use App\Domains\Internal\Models\InternalAdmin;
use App\Imports\Ministries\MinistryExcel;
use App\Models\Enumeration\GenderEnum;
use App\Models\Enumeration\ModelEnum;
use App\Models\Enumeration\SettingEnum;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Excel;
use Illuminate\Database\Seeder;

class FakeUserSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $internals = [
           [
               'type' => SettingEnum::TYPE_INTERNAL_ADMIN,
               'password' => bcrypt(config('auth.internal_admin_default_password')),
               'code' => generate_code_number(ModelEnum::INTERNALADMIN),
               'first_name_en' => 'BUN',
               'first_name_km' => 'ប៊ុន',
               'last_name_en' => 'Arya',
               'last_name_km' => 'អារីយ៉ា',
               'phone_number' => '38778494',
               'email' => 'bunarya0033@gmail.com',
               'gender'=> GenderEnum::F,
               'email_verified_at' => now(),
               'active' => true,
           ],
       ];
        $externals = [
            [
                'type' => SettingEnum::TYPE_EXTERNAL_ADMIN,
                'password' => bcrypt(config('auth.external_admin_default_password')),
                'code' => generate_code_number(ModelEnum::EXTERNALADMIN),
                'first_name_en' => 'Test',
                'first_name_km' => 'test',
                'last_name_en' => 'User',
                'last_name_km' => 'user',
                'phone_number' => '163228503',
                'email' => 'test@gmail.com',
                'gender'=> GenderEnum::M,
                'email_verified_at' => now(),
                'active' => true,
            ]
        ];

        foreach ($internals as $internal) {
            $internalAdmin = InternalAdmin::create($internal);
            $internalAdmin->assignRole([Role::where('name', config('boilerplate.access.role.internal_admin'))->first()->id]);
        }
        foreach ($externals as $external) {
            $externalAdmin = ExternalAdmin::create($external);
            $externalAdmin->assignRole([Role::where('name', config('boilerplate.access.role.external_admin'))->first()->id]);
        }
    }
}
