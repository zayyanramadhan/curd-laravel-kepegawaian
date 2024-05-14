<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\employee_id;
use Illuminate\Support\Facades\Validator;
use App\Models\EmployeeProfile;
use App\Models\Employee;


class EmployeeProfileController extends Controller
{
    public function GetData(Request $request) {

        $validation = Validator::make($request->all() ,[
            'id_employee' => 'required|numeric',
        ]);
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $data = Employee::find($request->id_employee)->profile()->orderBy('id')->paginate();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function Create(Request $request) {
        $validation = Validator::make($request->all() ,[
            'employee_id' => ['required','numeric',new employee_id],
            'date_of_birth' => 'date',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'is_married' => 'boolean',
            'created_by' => 'max:255',
            'updated_by' => 'max:255',
        ]);
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $prof = new EmployeeProfile;
 
        $prof->employee_id = $request->employee_id;
        $prof->place_of_birth = $request->place_of_birth;
        $prof->date_of_birth = $request->date_of_birth;
        $prof->gender = $request->gender;
        $prof->is_married = $request->is_married;
        $prof->prof_pict = $request->prof_pict;
        $prof->created_by = $request->created_by;
        $prof->updated_by = $request->updated_by;
 
        $prof->save();


        return response()->json([
            'response' => 'success created',
            'id' => $prof->id,
        ]);
    }

    public function Update(Request $request) {
        $validation = Validator::make($request->all() ,[
            'id' => 'required|numeric',
            'employee_id' => ['required','numeric',new employee_id],
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'is_married' => 'boolean',
            'created_by' => 'max:255',
            'updated_by' => 'max:255',
        ]);
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $prof = EmployeeProfile::find($request->id);
        if (empty($prof)) {
            return response()->json(['errors'=>'id not found.']);
        }
 
        $prof->employee_id = $request->employee_id;
        $prof->place_of_birth = $request->place_of_birth;
        $prof->date_of_birth = $request->date_of_birth;
        $prof->gender = $request->gender;
        $prof->is_married = $request->is_married;
        $prof->prof_pict = $request->prof_pict;
        $prof->updated_by = $request->updated_by;
 
        $prof->save();

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

        $prof = EmployeeProfile::find($request->id); 
        if (empty($prof)) {
            return response()->json(['errors'=>'id not found.']);
        }
        
        $prof->delete();

        return response()->json([
            'response' => 'success deleted',
        ]);
    }
}
