<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use  Spatie\Permission\Models\Permission;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $admin = User::first();
        $admin->assignRole('Admin');
        $adminRole = Role::where('name', 'Admin')->first();
        $adminRole->givePermissionTo(Permission::pluck('id','id')->toArray());
    }
}
