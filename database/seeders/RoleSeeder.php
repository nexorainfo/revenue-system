<?php

namespace Database\Seeders;

use App\Models\UserManagement\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Role::where('type','Super')->exists()){
            Role::create([
                'title' => 'Super Admin',
                'type' => 'Super',
            ]);
        }

    }
}
