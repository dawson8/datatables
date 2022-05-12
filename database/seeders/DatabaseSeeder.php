<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Guest',
            'email' => 'guest@example.com'
        ]);

        for($i = 1; $i < 8; $i++) {
            \App\Models\Classes::factory(1)->create([
                'name' => 'Class ' . $i
            ]);
        }

        $sections = ['A', 'B', 'C', 'D', 'E'];

        foreach($sections as $section) {
            \App\Models\Section::factory(1)->create([
                'name' => 'Section ' . $section
            ]);
        }

        \App\Models\Student::factory(100)->create();
    }
}
