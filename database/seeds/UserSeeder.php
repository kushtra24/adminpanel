<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'kushtrim',
            'email' => 'kushtra24@gmail.com',
            'password' => bcrypt('kushtrim'),
            'type' => 'admin',
            'active' => true,
        ]);

    }
}
