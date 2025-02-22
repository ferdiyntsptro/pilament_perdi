<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat peran admin dan user
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        Role::create(['ferdi' => 'user']);
    }
}
