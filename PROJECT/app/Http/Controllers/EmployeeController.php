<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function GetData(Request $request) {

        $data = Employee::select(DB::raw("employee.id as employee_id,employee.nik,employee.name,employee.is_active,employee_profile.gender, 
        CONCAT(EXTRACT(YEAR FROM AGE(employee_profile.date_of_birth)), ' Years Old'),
        education.description as school_name, education.level, 
        CASE 
        WHEN 
                SUM(CASE WHEN employee_family.relation_status = 'Anak Sambung' THEN 1 ELSE 0 END) = 0 AND 
                SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) = 0 AND 
                SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END) = 0 AND 
                SUM(CASE WHEN employee_family.relation_status = 'Anak' THEN 1 ELSE 0 END) = 0 THEN  
                        ' - ' 
        ELSE 	
        CASE 
            WHEN 
                SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 THEN 
                    CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END), ' Suami') 
                ELSE '' 
        END ||
        CASE 
            WHEN 
                SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END) > 0 THEN 
                    CASE WHEN 
                        SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 THEN 
                            ' & ' 
                        ELSE 
                            '' 
                    END || 
                    CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END), ' Istri') 
                ELSE '' 
        END ||
        CASE 
            WHEN 
                SUM(CASE WHEN employee_family.relation_status = 'Anak' THEN 1 ELSE 0 END) > 0 THEN 
                    CASE WHEN 
                        SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 OR 
                        SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END) > 0 THEN 
                            ' & ' 
                        ELSE 
                            '' 
                    END || 
                    CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Anak' THEN 1 ELSE 0 END), ' Anak') 
                ELSE '' 
        END ||
        CASE 
            WHEN 
                SUM(CASE WHEN employee_family.relation_status = 'Anak Sambung' THEN 1 ELSE 0 END) > 0 THEN 
                    CASE WHEN 
                        SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 OR 
                        SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END) > 0 OR 
                        SUM(CASE WHEN employee_family.relation_status = 'Anak' THEN 1 ELSE 0 END) > 0 THEN 
                            ' & ' 
                        ELSE 
                            '' 
                    END || 
                    CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Anak Sambung' THEN 1 ELSE 0 END), ' Anak Sambung') 
                ELSE '' 
        END
        END AS family_data"))
        ->leftJoin('education', 'employee.id', '=', 'education.employee_id')
        ->leftJoin('employee_profile', 'employee.id', '=', 'employee_profile.employee_id')
        ->leftJoin('employee_family', 'employee.id', '=', 'employee_family.employee_id')
        ->where('employee.is_active',true)
        ->groupBy('employee.id','employee_profile.gender','employee_profile.date_of_birth','education.description','education.level')
        ->orderBy('employee.id')
        ->paginate();

        return response()->json([
            'data' => $data,
        ]);
    }

    
    public function Create(Request $request) {
        $validation = Validator::make($request->all() ,[
            'start_date' => 'date',
            'end_date' => 'date',
            'created_by' => 'max:255',
            'updated_by' => 'max:255',
        ]);
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $fam = new Employee;
 
        $fam->nik = $request->nik;
        $fam->name = $request->name;
        $fam->is_active = 1;
        $fam->start_date = $request->start_date;
        $fam->end_date = $request->end_date;
        $fam->created_by = $request->created_by;
        $fam->updated_by = $request->updated_by;
 
        $fam->save();


        return response()->json([
            'response' => 'success created',
            'id' => $fam->id,
        ]);
    }

    public function Update(Request $request) {
        $validation = Validator::make($request->all() ,[
            'id' => 'required|numeric',
            'is_active' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
            'created_by' => 'max:255',
            'updated_by' => 'max:255',
        ]);
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $fam = Employee::find($request->id);
        if (empty($fam)) {
            return response()->json(['errors'=>'id not found.']);
        }
 
        $fam->nik = $request->nik;
        $fam->name = $request->name;
        $fam->is_active = $request->is_active;
        $fam->start_date = $request->start_date;
        $fam->end_date = $request->end_date;
        $fam->updated_by = $request->updated_by;
 
        $fam->save();

        return response()->json([
            'response' => 'success updated',
        ]);
    }

    public function Delete(Request $request) {
        $validation = Validator::make($request->all() ,[
            'id' => 'required|numeric',
        ]);
        
        $fam = Employee::find($request->id);
        if (empty($fam)) {
            return response()->json(['errors'=>'id not found.']);
        }

        $fam->is_active = 0;
        $fam->updated_by = now();
 
        $fam->save();

        return response()->json([
            'response' => 'success deleted',
        ]);
    }
}

// select employee.id as employee_id,employee.nik,employee.name,employee.is_active,employee_profile.gender, employee_profile.date_of_birth as age, education.description as school_name, education.level, 
// CASE 
//         WHEN 
//             SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 THEN 
//                 CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END), ' Suami') 
//             ELSE '' 
//     END ||
//     CASE 
//         WHEN 
//             SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END) > 0 THEN 
//                 CASE WHEN 
//                     SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 THEN 
//                         ' & ' 
//                     ELSE 
//                         '' 
//                 END || 
//                 CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END), ' Istri') 
//             ELSE '' 
//     END ||
//     CASE 
//         WHEN 
//             SUM(CASE WHEN employee_family.relation_status = 'Anak' THEN 1 ELSE 0 END) > 0 THEN 
//                 CASE WHEN 
//                     SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 OR 
//                     SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END) > 0 THEN 
//                         ' & ' 
//                     ELSE 
//                         '' 
//                 END || 
//                 CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Anak' THEN 1 ELSE 0 END), ' Anak') 
//             ELSE '' 
//     END ||
//     CASE 
//         WHEN 
//             SUM(CASE WHEN employee_family.relation_status = 'Anak Sambung' THEN 1 ELSE 0 END) > 0 THEN 
//                 CASE WHEN 
//                     SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 OR 
//                     SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END) > 0 OR 
//                     SUM(CASE WHEN employee_family.relation_status = 'Anak' THEN 1 ELSE 0 END) > 0 THEN 
//                         ' & ' 
//                     ELSE 
//                         '' 
//                 END || 
//                 CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Anak Sambung' THEN 1 ELSE 0 END), ' Anak Sambung') 
//             ELSE '' 
//     END AS family_data         
//  from employee inner join education on employee.id = education.employee_id inner join employee_profile on employee.id = employee_profile.employee_id inner join employee_family on employee.id = employee_family.employee_id group by employee.id, employee_profile.gender, employee_profile.date_of_birth, education.description, education.level
