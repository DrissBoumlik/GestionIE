<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->insert([
            ['name' => 'superAdmin', 'description' => 'super admin'],
            ['name' => 'admin', 'description' => 'admin'],
            ['name' => 'agence', 'description' => 'Agence'],
            ['name' => 'agent', 'description' => 'Agent'],
        ]);
    }
}
