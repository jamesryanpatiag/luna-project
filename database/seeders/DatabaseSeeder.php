<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'contractor_id_number' => '0000',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'is_active' => true,
            'email' => 'admin@mindnation.com',
            'contractor_position' => 'Administrator',
            'date_hired' => '2025-01-01',
            'regularization_date' => '2025-01-01',
            'hmo_active' => true,
            'gender' => 'MALE',
            'password' => bcrypt('!Password@123'),
        ]);
    }
}
