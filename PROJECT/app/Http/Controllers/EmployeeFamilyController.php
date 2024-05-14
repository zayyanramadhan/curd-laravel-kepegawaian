<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\employee_id;
use Illuminate\Support\Facades\Validator;
use App\Models\EmployeeFamily;
use App\Models\Employee;


class EmployeeFamilyController extends Controller
{
    public function GetData(Request $request) {

        $validation = Validator::make($request->all() ,[
            'id_employee' => 'required|numeric',
        ]);
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $data = Employee::find($request->id_employee)->family()->orderBy('id')
        ->paginate();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function Create(Request $request) {
        $validation = Validator::make($request->all() ,[
            'employee_id' => ['required','numeric',new employee_id],
            'identifer' => 'max:255',
            'job' => 'max:255',
            'date_of_birth' => 'date',
            'religion' => 'required|in:Islam,Katolik,Buda,Protestan,Konghucu',
            'is_married' => 'boolean',
            'is_divorced' => 'boolean',
            'relation_status' => 'required|in:Suami,Istri,Anak,Anak Sambung',
            'created_by' => 'max:255',
            'updated_by' => 'max:255',
        ]);
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $fam = new EmployeeFamily;
 
        $fam->employee_id = $request->employee_id;
        $fam->name = $request->name;
        $fam->identifer = $request->identifer;
        $fam->job = $request->job;
        $fam->place_of_birth = $request->place_of_birth;
        $fam->date_of_birth = $request->date_of_birth;
        $fam->religion = $request->religion;
        $fam->is_life = $request->is_life;
        $fam->is_divorced = $request->is_divorced;
        $fam->relation_status = $request->relation_status;
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
            'employee_id' => ['required','numeric',new employee_id],
            'identifer' => 'max:255',
            'job' => 'max:255',
            'religion' => 'required|in:Islam,Katolik,Buda,Protestan,Konghucu',
            'is_married' => 'boolean',
            'is_divorced' => 'boolean',
            'relation_status' => 'required|in:Suami,Istri,Anak,Anak Sambung',
            'created_by' => 'max:255',
            'updated_by' => 'max:255',
        ]);
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $fam = EmployeeFamily::find($request->id);
        if (empty($fam)) {
            return response()->json(['errors'=>'id not found.']);
        }
 
        $fam->employee_id = $request->employee_id;
        $fam->name = $request->name;
        $fam->identifer = $request->identifer;
        $fam->job = $request->job;
        $fam->place_of_birth = $request->place_of_birth;
        $fam->date_of_birth = $request->date_of_birth;
        $fam->religion = $request->religion;
        $fam->is_life = $request->is_life;
        $fam->is_divorced = $request->is_divorced;
        $fam->relation_status = $request->relation_status;
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
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $fam = EmployeeFamily::find($request->id); 
        if (empty($fam)) {
            return response()->json(['errors'=>'id not found.']);
        }
        
        $fam->delete();

        return response()->json([
            'response' => 'success deleted',
        ]);
    }
}
