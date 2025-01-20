<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use  Spatie\Permission\Models\Permission;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'name'              => 'Admin',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Member',
                'guard_name'        => 'web',
            ]
        ]);
    }
}
