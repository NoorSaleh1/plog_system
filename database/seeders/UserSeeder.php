<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Noor ',
            'email' => 'user@example.com',
            'password' => Hash::make('mmmmmmmmm'),
        ]);


        User::create([
            'name' => 'مستخدم آخر',
            'email' => 'anotheruser@example.com',
            'password' => Hash::make('كلمة المرور'),
        ]);
        User::create([
            'name' => 'Noor ',
            'email' => 'user@example.com',
            'password' => Hash::make('mmmmmmmmm'),
        ]);
        

    }
}
