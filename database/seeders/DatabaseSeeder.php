<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $id = DB::table('users')->insertGetId([
            'type' => User::TYPE_ADMIN,
            'name' => 'Administrator',
            'email' => 'admin@ult.go.id',
            'password' => Hash::make('password'),
        ]);

        $permissionMapping = Role::getPermissionMapping();

        DB::table('roles')->insert([
            'user_id' => $id,
            'permissions' => json_encode(
                array_map(function ($key) {
                    return true;
                }, $permissionMapping),
            ),
        ]);
    }
}
