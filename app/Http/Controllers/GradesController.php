<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grades;
use Illuminate\Support\Facades\Auth;
class GradesController extends Controller
{
    
    public function addGradeToSubject(Request $request){
        
           $validated = $request->validate([
            "student_id" => "required|integer|exists:users,id",
            "subject_id" => "required|integer|exists:subjects,id",
            "score" => "required|numeric|min:0|max:100",
            "remarks" => "nullable|string|max:255"
           ]);

           try{
            $user = Auth::user();
            if (!$user || Auth::check() === false){
                return response()->json(['message' => "User is not logged in"], 422);
            }
            $userRole = Auth::user()->role;
            if ($userRole !== 'teacher'){
                return response()->json(["mesage" => "User is not authorized to grade this subject"], 422);
            }

            $newGrade = Grades::create([
                "student_id" => $validated["student_id"],
                "subject_id" => $validated["subject_id"],
                "score" => $validated["score"],
                "remarks" => $validated["remarks"] ?? null
            ]);

            return response()->json(["message" => "Grade added succesfully", "grade" => $newGrade], 200);
           } catch (\Exception $e){
            return response()->json(["message" => "Error adding grade", "error" => $e->getMessage()], 500);
           }
    }

   
}
