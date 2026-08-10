<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $roles = ['user', 'super-admin'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $admin = User::firstOrCreate(
            ['mobile' => '09123456789'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('1234'),
            ]
        );


        $admin->syncRoles($roles);
    }
}
