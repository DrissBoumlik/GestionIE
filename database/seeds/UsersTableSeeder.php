<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstname' => 'John',
            'lastname' => 'SuperAdmin',
            'email' => 'sa@a.a',
            'status' => true,
            'picture' => '/media/avatars/superAdmin.png',
            'gender' => 'male',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'role_id' => 1
        ]);
        User::create([
            'firstname' => 'John',
            'lastname' => 'Admin',
            'email' => 'a@a.a',
            'status' => true,
            'picture' => '/media/avatars/admin.png',
            'gender' => 'male',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'role_id' => 2
        ]);
        User::create([
            'firstname' => 'John',
            'lastname' => 'Agent',
            'email' => 'agt@a.a',
            'status' => true,
            'picture' => '/media/avatars/user.png',
            'gender' => 'male',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'role_id' => 3
        ]);
        User::create([
            'firstname' => 'John',
            'lastname' => 'B2bSfr',
            'email' => 'b2bSfr@circet.fr',
            'status' => true,
            'picture' => '/media/avatars/superAdmin.png',
            'gender' => 'male',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'role_id' => 4
        ]);


        //new agents
        User::create([
            'firstname' => 'Majdouline',
            'lastname' => 'ABDELHAKIM',
            'email' => 'majdouline.abdelhakim@circet.fr',
            'status' => true,
            'picture' => '/media/avatars/female.png',
            'gender' => 'female',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'role_id' => 3
        ]);
        User::create([
            'firstname' => 'Hasnaa',
            'lastname' => 'HARAKATI',
            'email' => 'hasnaa.harakati@circet.fr',
            'status' => true,
            'picture' => '/media/avatars/female.png',
            'gender' => 'female',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'role_id' => 3
        ]);
        User::create([
            'firstname' => 'Yasmine',
            'lastname' => 'EL-KAMA',
            'email' => 'yasmine.el-kama@circet.fr',
            'status' => true,
            'picture' => '/media/avatars/female.png',
            'gender' => 'female',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'role_id' => 3
        ]);
            User::create([
            'firstname' => 'Chaimaa',
            'lastname' => 'CHOUHBI',
            'email' => 'chaimaa.chouhbi@circet.fr',
            'status' => true,
            'picture' => '/media/avatars/female.png',
            'gender' => 'female',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'role_id' => 3
        ]);
            User::create([
            'firstname' => 'Oumayma',
            'lastname' => 'BOUCHACHIA',
            'email' => 'oumayma.bouchachia@circet.fr',
            'status' => true,
            'picture' => '/media/avatars/female.png',
            'gender' => 'female',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'role_id' => 3
        ]);
            User::create([
            'firstname' => 'Jihane',
            'lastname' => 'KHOUYA',
            'email' => 'jihane.khouya@circet.fr',
            'status' => true,
            'picture' => '/media/avatars/female.png',
            'gender' => 'female',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'role_id' => 3
        ]);
    }
}
