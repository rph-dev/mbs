<?php

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
        DB::table('users')->insert([
            'name' => 'demo',
            'email' => 'demo@email.com',
            'password' => bcrypt('demo'),
            'department_id' => 5,
            'position_id' => 4,
            'activated' => 1,
            'line_code' => 123456,
            'birth_date' => '1990-10-01'
        ]);
    }
}
