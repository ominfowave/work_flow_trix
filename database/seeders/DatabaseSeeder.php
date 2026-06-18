<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Admin, Tech};
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if(!Admin::exists()){
            $superAdminRole =  [
                'name' => 'Super-admin',
                'guard_name' => 'admin',
                'status' => 'active'
            ];
    
            $role = Role::create($superAdminRole);
    
            $permissions = [
                    "client-view",
                    "client-edit",
                    "client-add",
                    "client-delete",
    
                    "project-view",
                    "project-edit",
                    "project-add",
                    "project-delete",
    
                    "user-view",
                    "user-edit",
                    "user-add",
                    "user-delete",
    
                    "role-view",
                    "role-edit",
                    "role-add",
                    "role-delete",
    
                    "message-show",
    
                    "tech-view",
                    "tech-edit",
                    "tech-add",
                    "tech-delete",
    
                    "admin-dashboard"
                ];
    
            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'admin'
                ]);
            }
    
            $role->syncPermissions($permissions);
    
            $admin = Admin::create([
                'full_name' => 'vishal',
                'name' => 'vishal',
                'password' => bcrypt('12345'),
                'role_id' => 1,
                'tech_id' => 1,
                'status' => 'active',
            ]);
    
            $admin->assignRole($role->name);
    
            Role::insert([
                [
                    'name' => 'Admin',
                    'guard_name' => 'admin',
                    'status' => 'active'
                ],
                [
                    'name' => 'Devloper',
                    'guard_name' => 'admin',
                    'status' => 'active'
                ],
                [
                    'name' => 'Desiner',
                    'guard_name' => 'admin',
                    'status' => 'active'
                ],
                [
                    'name' => 'Hr',
                    'guard_name' => 'admin',
                    'status' => 'active'
                ],
                [
                    'name' => 'Intern',
                    'guard_name' => 'admin',
                    'status' => 'active'
                ]
            ]);
    
            Tech::insert([
                [
                'tech_name' => 'Angular',
                'tech_icon' => '',
                'status' => 'active'
                ],
                [
                'tech_name' => 'Android',
                'tech_icon' => '',
                'status' => 'active'
                ],
                [
                'tech_name' => 'React',
                'tech_icon' => '',
                'status' => 'active'
                ],
                [
                'tech_name' => 'PHP',
                'tech_icon' => '',
                'status' => 'active'
                ]
            ]);
        }
    }
}
