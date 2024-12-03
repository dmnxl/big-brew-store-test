<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserAcc;

class AddSuperAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add a super admin account directly into the user_accs table
        UserAcc::create([
            'name' => 'super_admin',
            'email' => 'super_admin@example.com',
            'password' => bcrypt('Password123!'), // Using bcrypt here
            'role' => 0, // Super admin role
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // If needed, you can rollback the super admin user
        UserAcc::where('email', 'super_admin@example.com')->delete();
    }
}
