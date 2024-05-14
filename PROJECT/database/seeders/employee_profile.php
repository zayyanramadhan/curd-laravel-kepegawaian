<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class employee_profile extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gender = ['Laki-Laki', 'Perempuan'];
        $place_of_birth = ['Surabaya','Solo','Malang','Bandung','Yogyakarta','Madiun','Jakarta','Semarang','Padang'];
        for ($i=1; $i <= 20 ; $i++) { 
            $is_married=false;
            if ($i%2==0) {
                $is_married=true;
            }
            
            DB::table('employee_profile')->insert([
                'employee_id' => $i,
                'place_of_birth' => $place_of_birth[rand(0,8)],
                'date_of_birth' => date('Y-m-d', strtotime('-'.rand(1,30).' years')),
                'gender' => $gender[rand(0,1)],
                'is_married' => $is_married,
                'created_by' => 'Admin',
                'updated_by' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
