<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Example data
        $users = [
            [
                'ic' => '020830120078',
                'name' => 'Nurin',
                'password' => bcrypt('Nrn300802//'),
                'email' => 'nurinbatrisyia3008@yahoo.com',
                'role' => 'admin',
                'pass_status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
