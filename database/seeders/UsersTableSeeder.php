<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->updateOrInsert(
            ['ic' => '020830120078'], // Unique column to check
            [
                'name' => 'Nurin',
                'email' => 'nurinbatrisyia3008@yahoo.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'pass_status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}
