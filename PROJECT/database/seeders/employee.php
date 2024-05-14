<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class employee extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $randname = ['Mochammad','Zayyan','Ramadhan','Budi','Yono','Ahmad','Susi','Emilia','Rosa'];
        $randname2 = ['Sulis','Mawar','Fajar','Olive','Madun','Joko','Jaya','Kiki','Wendi'];
        for ($i=0; $i < 20 ; $i++) { 
            $name1 = $randname;
            $name2 = $randname2;
            if ($i%2==0) {
                $name1 = $randname2;
                $name2 = $randname;
            }
            DB::table('employee')->insert([
                'nik' => rand(3200000000000000,3299999999999999),
                'name' =>  $name1[rand(0,8)]." ".$name2[rand(0,8)],
                'is_active' => true,
                'start_date' => date('Y-m-d', strtotime('-'.rand(3,10).' years')),
                'end_date' => date('Y-m-d', strtotime('-'.rand(0,2).' years')),
                'created_by' => 'Admin',
                'updated_by' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
