<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
            ['name' => 'ผู้อำนวยการ'],
            ['name' => 'ผู้จัดการ'],
            ['name' => 'เลขานุการ'],
            ['name' => 'พนักงาน']
        ]);
    }
}
