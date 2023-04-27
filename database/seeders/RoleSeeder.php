<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'name' => 'admin',
                'guard_name' => 'web'
            ],
            [
                'name' => 'super-admin',
                'guard_name' => 'web'
            ],
            [
                'name' => 'hr-manager',
                'guard_name' => 'web'
            ],
            [
                'name' => 'hr-assistant',
                'guard_name' => 'web'
            ],
            [
                'name' => 'team-lead',
                'guard_name' => 'web'
            ],
            [
                'name' => 'employee',
                'guard_name' => 'web'
            ],
            [
                'name' => 'applicant',
                'guard_name' => 'web'
            ]
        ];

        foreach ($status as $key => $value) {
            Role::firstOrCreate($value);
        }
    }
}
