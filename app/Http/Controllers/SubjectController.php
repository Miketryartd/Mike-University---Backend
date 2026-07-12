<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subjects;
class SubjectController extends Controller
{
    public function addSubject(Request $request){
        
            $validated = $request->validate([
                "subject_name" => "required|string|unique:subjects,subject_name|max:255"
            ]);

            try{
                
            $user = Auth::user();
            if (!$user || Auth::check() === false){
                return response()->json(["mesage" => "User is not logged in"], 422);
            }
            if ($user->role !== "teacher"){
                return response()->json(["mesage" => "User is not authorized to add a subject"], 422);
            }

            do {
                $subject_code = random_int(100000, 999999);
            } while (Subjects::where("subject_code", $subject_code)->exists());


              $newSubject = Subjects::create([
                "subject_name" => $validated["subject_name"],
                "subject_code" => $subject_code,
                "teacher_id" => $user->id
            ]);

            return response()->json(["message" => "Subject added succesfully", "Subject:" => $newSubject], 200);
            } catch (\Exception $e){
                return response()->json(["message" => "Error adding subject", "error:" => $e->getMessage()], 500);
            }
          
          }
}
