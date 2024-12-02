<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserAcc; // Import the UserAcc model

class user_accs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a sample user account
        UserAcc::create([
            'name' => 'sample_user', // Change 'username' to 'name' based on your migration
            'email' => 'sample_user@example.com',
            'password' => 'password123', // Will be hashed automatically by the model
            'role' => 1, // Assign a role (e.g., 0 for user, 1 for admin)
        ]);
    }
}
