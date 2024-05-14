<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class education extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $level = ['Tk', 'Sd', 'Smp', 'Sma', 'Strata 1', 'Strata 2', 'Doktor', 'Profesor'];
        $education = ["Swasta 1","Swasta 2","Swasta 3","Negeri 1","Negeri 2","Negeri 3"];
        for ($i=1; $i <= 20 ; $i++) { 
            $is_married=false;
            if ($i%2==0) {
                $is_married=true;
            }

            $setlevel = $level[rand(0,7)];
            $setedu = $education[rand(0,5)];
            
            DB::table('education')->insert([
                'employee_id' => $i,
                'name' => $setedu,
                'level' => $setlevel,
                'is_married' => $is_married,
                'description' => $setlevel." ".$setedu,
                'created_by' => 'Admin',
                'updated_by' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
