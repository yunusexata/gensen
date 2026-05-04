<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => "Admin",
            'username' => "admin",
            'email' => "admin@gmail.com",
            'password' => Hash::make("123exata"),
        ]);

        $user->assignRole(User::ROLE_SUPER_ADMIN);

        // PAK NOVI
        $user = User::create([
            'name' => "Novi Prayitno",
            'username' => "Novi Prayitno",
            'email' => "snoopy.exataindonesia2018@gmail.com",
            'password' => Hash::make("123exata"),
        ]);

        $user->assignRole(User::ROLE_SUPER_ADMIN);

        // SUPERVISOR
        $user = User::create([
            'name' => "Febtio",
            'username' => "Febtio",
            'email' => "febtio.exataindonesia2019@gmail.com",
            'password' => Hash::make("123exata"),
        ]);

        $user->assignRole(User::ROLE_SUPERVISOR);

        // HS
        $user = User::create([
            'name' => "Vita",
            'username' => "Vita",
            'email' => "dira.exataindonesia2018@gmail.com",
            'pic_code' => 'AI',
            'password' => Hash::make("123exata"),
        ]);
        $user->assignRole(User::ROLE_HS);

        $user = User::create([
            'name' => "Cynthia",
            'username' => "Cynthia",
            'email' => "amin.exataindonesia2021@gmail.com",
            'pic_code' => 'MT',
            'password' => Hash::make("123exata"),
        ]);

        $user->assignRole(User::ROLE_HS);
        $user = User::create([
            'name' => "Mutia",
            'username' => "Mutia",
            'email' => "internship.exatagroup05@gmail.com",
            'pic_code' => 'SN',
            'password' => Hash::make("123exata"),
        ]);
        $user->assignRole(User::ROLE_HS);

        // HS 2
        $user = User::create([
            'name' => "Rina",
            'username' => "Rina",
            'email' => "rinaexataindonesia@gmail.com",
            'password' => Hash::make("123exata"),
        ]);

        $user->assignRole(User::ROLE_HS2);

        // SALES
        $user = User::create([
            'name' => "Ainul",
            'username' => "Ainul",
            'email' => "ajmain.exataindonesia2018@gmail.com",
            'pic_code' => 'AI',
            'password' => Hash::make("123exata"),
            'password_gensen_form' => "ainulexata123",
        ]);

        $user->assignRole(User::ROLE_SALES);

        $user = User::create([
            'name' => "Mukhamad Turhamun",
            'username' => "Mukhamad Turhamun",
            'email' => "kim.exataindonesia2018@gmail.com",
            'pic_code' => 'MT',
            'password' => Hash::make("123exata"),
            'password_gensen_form' => "kimexata123",
        ]);
        $user->assignRole(User::ROLE_SALES);

        $user = User::create([
            'name' => "Selamet Syafaruddin",
            'username' => "Selamet Syafaruddin",
            'email' => "eza.exataindonesia2018@gmail.com",
            'pic_code' => 'SN',
            'password' => Hash::make("123exata"),
            'password_gensen_form' => "selametexata123",
        ]);

        $user->assignRole(User::ROLE_SALES);

        // ACC EXATA
        $user = User::create([
            'name' => "Nurul",
            'username' => "Nurul",
            'email' => "nurul.exataindonesia2018@gmail.com",
            'password' => Hash::make("123exata"),
        ]);

        $user->assignRole(User::ROLE_ACC_EXATA);

        // ADMIN JAPAN
        $user = User::create([
            'name' => "Admin Japan",
            'username' => "Admin Japan",
            'email' => "adminjapan@gmail.com",
            'password' => Hash::make("123exata"),
        ]);

        $user->assignRole(User::ROLE_ADMIN_JAPAN);
    }
}
