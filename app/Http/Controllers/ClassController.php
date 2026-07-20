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
        "class_name" => "string|required|max:255",
        "class_code" => "nullable|string"
   
      ]);
   try{
   
    if (!$user || Auth::check() === false){
        return response()->json(["message" => "User not logged in"], 422);
    }
        $newClass = Classes::create([
           "class_name" => $validated["class_name"],
           "class_code" => $validated["class_code"],
           "creator_id" => $user->id ,
           
        ]);
        return response()->json(["message" => "Class created succesfully", "class" => $newClass], 200);
         
   } catch (\Exception $e){
    return response()->json(["message" => "Error creating class", "error" => $e->getMessage()], 500);
   }
}
    
}
