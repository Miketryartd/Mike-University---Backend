<?php

namespace App\Http\Controllers;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
   
    
public function CreateClass(Request $request){
    
 $user = Auth::user();
      $validated = $request->validate([
        "subject_name" => "string|required|max:255",
        "class_section" => "string|required|max:255",
        "class_code" => "nullable|string"
   
      ]);
   try{
   
    if (!$user || Auth::check() === false){
        return response()->json(["message" => "User not logged in"], 422);
    }
        $newClass = Classes::create([
           "subject_name" => $validated["subject_name"],
           "class_section" => $validated["class_section"],
           "class_code" => $validated["class_code"],
           "creator_id" => $user->id ,
           "user_email" => $user->email
           
        ]);
        return response()->json(["message" => "Class created succesfully", "class" => $newClass], 200);
         
   } catch (\Exception $e){
    return response()->json(["message" => "Error creating class", "error" => $e->getMessage()], 500);
   }
}
    
public function GetClasses(){

  try{
   $user = Auth::user();
   if (!$user || Auth::check() === false){
      return response()->json(["message" => "User not auth"], 422);
   }
   $fetchClasses = Classes::query()->where("id", "LIKE", "%{$user->id}%")->orWhere("user_email", 'LIKE', "%{$user->email}%")->paginate(10);
   if (!$fetchClasses){
      return response()->json(["message" => "No classes found"], 404);
   } else {
      return response()->json(["message" => "Succesfully fetched classes", "classes" => $fetchClasses], 200);
  }
   } catch (\Exception $e){
      return response()->json(["message" => "Error getting user classes", "error" => $e->getMessage()], 500);
   }
}
}
