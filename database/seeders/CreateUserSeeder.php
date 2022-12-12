<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => ['en' => 'ouafa', 'ar' => 'وفاء'],
            'email' => 'ouafa@gmail.com',
            'password' => Hash::make('123456'),
            'roles_name' => ["ouafa"],
            // 'Status_spaties' => 'مفعل',
            'nickname' => 'ouafa',
            'github_id' => 'null',
            'firstname' => 'null',
            'lastname' => 'null',
            'designation' => 'null',
            'website' => 'null',
            'phone' => 'null',
            'Address' => 'null',
            'twitter' => 'null',
            'facebook' => 'null',
            'google' => 'null',
            'linkedin' => 'null',
            'github' => 'null',
            'biographicalinfo' => 'null',
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);

            $role = Role::create(['name' => 'Admin']);

            $permissions = Permission::pluck('id','id')->all();

            $role->syncPermissions($permissions);

            $user->assignRole([$role->id]);

    }
}
