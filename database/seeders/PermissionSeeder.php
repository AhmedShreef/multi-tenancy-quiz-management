<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
       {
       
        $permissions = config('system.permissions');
        $i = 1;
        foreach ($permissions as $permission) {
            if($permission['crud']){
                foreach (['list', 'create', 'edit', 'delete'] as $perm) {
                    if(!Permission::where('name', $perm . '-' . $permission['name'])->first()){
                        Permission::create([
                            'id'    =>  $i++,
                            'guard_name' => 'web',
                            'name'  =>  $perm . '-' . $permission['name'],
                        ]);
                    }
                }
            }else{
                if(!Permission::where('name', $permission['name'])->first()){
                    Permission::create([
                        'id'    =>  $i++,
                        'guard_name' => 'web',
                        'name'  =>  $permission['name'],
                    ]);
                }
            }
        }
    }
}
