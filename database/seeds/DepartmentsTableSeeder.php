<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('departments')->count()){
            DB::table('departments')->insert([
                ['name' => 'สำนักผู้อำนวยการ'],
                ['name' => 'ฝ่ายบริหารทั่วไป'],
                ['name' => 'ฝ่ายบริหารทรัพยากรมนุษย์'],
                ['name' => 'ฝ่ายบัญชีและการเงิน'],
                ['name' => 'ฝ่ายเทคโนโลยีและสารสนเทศ'],
            ]);
        }
    }
}
