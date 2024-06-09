<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
        public function run()
        {
            $this->call([
                UsersTableSeeder::class,
                ContactsTableSeeder::class,
                CategoryTableSeeder::class,
                PsychologistsTableSeeder::class,
                StudentsTableSeeder::class,
                QuestionsTableSeeder::class,
                StudentQuestionTableSeeder::class,
                SettingsTableSeeder::class,
                ResultsTableSeeder::class,
                InterventionsTableSeeder::class,
                SessionsTableSeeder::class,
            ]);
        }
    }