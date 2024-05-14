<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class employee_family extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $religion = ['Islam', 'Katolik', 'Buda', 'Protestan', 'Konghucu'];
        $relation_status = ['Suami', 'Istri', 'Anak', 'Anak Sambung'];
        $place_of_birth = ['Surabaya','Solo','Malang','Bandung','Yogyakarta','Madiun','Jakarta','Semarang','Padang'];
        
        $randname = ['Mochammad','Zayyan','Ramadhan','Budi','Yono','Ahmad','Susi','Emilia','Rosa'];
        $randname2 = ['Sulis','Mawar','Fajar','Olive','Madun','Joko','Jaya','Kiki','Wendi'];

        $jobs = ["Swasta","BUMN","Sipil","TNI","PNS","Pengusaha"];

        for ($i=1; $i <= 20 ; $i++) { 
            $is_divorced=false;
            $name1 = $randname;
            $name2 = $randname2;
            if ($i%2==0) {
                $is_divorced=true;
                $name1 = $randname2;
                $name2 = $randname;
            }
            
            DB::table('employee_family')->insert([
                'employee_id' => $i,
                'name' => $name1[rand(0,8)]." ".$name2[rand(0,8)],
                'identifer' => rand(3200000000000000,3299999999999999),
                'job' => $jobs[rand(0,5)],
                'place_of_birth' => $place_of_birth[rand(0,8)],
                'date_of_birth' => date('Y-m-d', strtotime('-'.rand(1,30).' years')),
                'religion' => $religion[rand(0,4)],
                'is_life' => true,
                'is_divorced' => $is_divorced,
                'relation_status' => $relation_status[rand(0,3)],
                'created_by' => 'Admin',
                'updated_by' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
