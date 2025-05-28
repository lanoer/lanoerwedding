<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'isActive' => true,
        ];
        DB::beginTransaction();
        try {

            $admin = User::create(array_merge([
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'verified' => true,
            ], $default_user_value));


            $superadmin = User::create(array_merge([
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@gmail.com',
                'verified' => true,

            ], $default_user_value));

            $ceo = User::create(array_merge([
                'name' => 'CEO',
                'username' => 'ceo',
                'email' => 'ceo@gmail.com',
                'verified' => true,

            ], $default_user_value));


            $author = User::create(array_merge([
                'name' => 'Author',
                'username' => 'author',
                'email' => 'author@gmail.com',
                'verified' => true,

            ], $default_user_value));

            $role_superadmin = Role::create(['name' => 'superadmin']);
            $role_admin = Role::create(['name' => 'admin']);
            $role_ceo = Role::create(['name' => 'ceo']);
            $role_author = Role::create(['name' => 'author']);

            $permission = Permission::create(['name' => 'create role']);
            $permission = Permission::create(['name' => 'read role']);
            $permission = Permission::create(['name' => 'update role']);
            $permission = Permission::create(['name' => 'delete role']);
            // end role
            $permission = Permission::create(['name' => 'create post']);
            $permission = Permission::create(['name' => 'read post']);
            $permission = Permission::create(['name' => 'update post']);
            $permission = Permission::create(['name' => 'delete post']);
            // end post

            $permission = Permission::create(['name' => 'read pages']);

            $permission = Permission::create(['name' => 'read setting']);


            $role_superadmin->givePermissionTo('create role');
            $role_superadmin->givePermissionTo('read role');
            $role_superadmin->givePermissionTo('update role');
            $role_superadmin->givePermissionTo('delete role');


            $role_superadmin->givePermissionTo('read setting');

            $role_admin->givePermissionTo('create role');
            $role_admin->givePermissionTo('read role');
            $role_admin->givePermissionTo('update role');
            $role_admin->givePermissionTo('delete role');

            $role_admin->givePermissionTo('create post');
            $role_admin->givePermissionTo('read post');
            $role_admin->givePermissionTo('update post');
            $role_admin->givePermissionTo('delete post');


            $role_admin->givePermissionTo('read setting');
            $role_admin->givePermissionTo('read setting');
            $role_admin->givePermissionTo('read pages');

            $admin->assignRole('admin');
            $superadmin->assignRole('superadmin');
            $ceo->assignRole('ceo');
            $author->assignRole('author');

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
