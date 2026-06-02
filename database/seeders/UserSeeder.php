<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'ict@mamatabd.org')->exists()) {
            User::create([
                'name' => 'Mamata ICT',
                'email' => 'ict@mamatabd.org',
                'username' => '021868',
                'password' => Hash::make('&&ict@@mamata?'),
            ])->markEmailAsVerified();
        }
    }
}
