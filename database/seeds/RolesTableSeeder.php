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
            ['name' => 'agent', 'description' => 'Agent'],
            ['name' => 'B2bSfr', 'description' => 'B2bSfr'],
            ['name' => 'B2bSfrAdmin', 'description' => 'B2bSfrAdmin'],
        ]);
    }
}
