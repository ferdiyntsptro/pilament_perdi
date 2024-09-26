<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        
        // Hapus role admin jika sudah ada
        Role::where('name', 'admin')->delete();

        // Tambahkan role admin
        $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);

        // Cek apakah pengguna admin sudah ada
        $user = User::where('email', 'admin@example.com')->first();

        // Jika pengguna admin belum ada, buat pengguna baru
        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password123'), // Ganti dengan password yang aman
            ]);
        }

        // Assign role admin ke pengguna
        $user->assignRole($role);

        echo "Role admin dan pengguna admin berhasil dibuat.\n";
    }
}
