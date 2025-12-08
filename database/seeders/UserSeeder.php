<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserManagement\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    final public function run(): void
    {
        if (!User::where('email', 'info@nifonepal.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'info@nifonepal.com',
                'password' => 'Nifonepal@123',
                'role_id' => Role::where('type', 'Super')->first()->id,
            ]);
        }
    }
}
