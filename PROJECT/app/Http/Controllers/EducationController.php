<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\employee_id;
use Illuminate\Support\Facades\Validator;
use App\Models\Education;
use App\Models\Employee;

class EducationController extends Controller
{
    public function GetData(Request $request) {

        $validation = Validator::make($request->all() ,[
            'id_employee' => 'required|numeric',
        ]);
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $data = Employee::find($request->id_employee)->education()->orderBy('id')->paginate();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function Create(Request $request) {
        $validation = Validator::make($request->all() ,[
            'employee_id' => ['required','numeric',new employee_id],
            'name' => 'required|max:255',
            'level' => 'required|in:Tk,Sd,Smp,Sma,Strata 1,Strata 2,Doktor,Profesor',
            'is_married' => 'boolean',
            'description' => 'max:255',
            'created_by' => 'max:255',
            'updated_by' => 'max:255',
        ]);
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $edu = new Education;
 
        $edu->employee_id = $request->employee_id;
        $edu->name = $request->name;
        $edu->level = $request->level;
        $edu->is_married = $request->is_married;
        $edu->description = $request->description;
        $edu->created_by = $request->created_by;
        $edu->updated_by = $request->updated_by;
 
        $edu->save();


        return response()->json([
            'response' => 'success created',
            'id' => $edu->id,
        ]);
    }

    public function Update(Request $request) {
        $validation = Validator::make($request->all() ,[
            'id' => 'required|numeric',
            'employee_id' => ['required','numeric',new employee_id],
            'name' => 'required|max:255',
            'level' => 'required|in:Tk,Sd,Smp,Sma,Strata 1,Strata 2,Doktor,Profesor',
            'is_married' => 'boolean',
            'description' => 'max:255',
            'created_by' => 'max:255',
            'updated_by' => 'max:255',
        ]);
        
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $edu = Education::find($request->id);
        if (empty($edu)) {
            return response()->json(['errors'=>'id not found.']);
        }
 
        $edu->employee_id = $request->employee_id;
        $edu->name = $request->name;
        $edu->level = $request->level;
        $edu->is_married = $request->is_married;
        $edu->description = $request->description;
        $edu->updated_by = $request->updated_by;
 
        $edu->save();

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

        $edu = Education::find($request->id); 
        if (empty($edu)) {
            return response()->json(['errors'=>'id not found.']);
        }

        $edu->delete();

        return response()->json([
            'response' => 'success deleted',
        ]);
    }
}
