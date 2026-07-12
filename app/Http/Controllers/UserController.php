<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
     
    
 
   public function Register(Request $request){

   try{
       $validated = $request->validate([
        "email" => "required|email|unique:users,email|string",
        "name" => "required|string|min:6|max:255",
        "password" => "required|string|min:6|max:255",
        "role" => "nullable|string|in:student,teacher,admin"
       ]);
       $newUser = User::create([
        "email" => $validated["email"],
        "name" => $validated["name"],
        "password" => $validated["password"],
        "role" => $validated["role"] ?? 'student',
        
       ]);

       return response()->json(["message" => "User created succesfully", "user" => $newUser], 201);

   } catch (\Exception $e){
    return response()->json(["message" => "Error creating user", "error" => $e->getMessage()], 500);
   }
   }


   public function Login(Request $request){
    try{
        $credentials = $request->validate([
            "email" => "required|email|string",
            "password" => "required|string",
          
        ]);

      if (Auth::attempt($credentials)){
        $token = $request->user()->createToken('user_token')->plainTextToken;
        return response()->json(["message" => "Login succesful", "user" => Auth::user(), "token" => $token], 200);
      } else {
        return response()->json(["message" => "Invalid credentials"], 401);
      }
   
    } catch (\Exception $e){
        return response()->json(["message" => "Error logging in", "error" => $e->getMessage()], 500);
    }
   }


   public function Logout(Request $request){
    try{
        $user = Auth::user();
        if (!$user || Auth::check() === false){
            return response()->json(["message" => "User not authenticated"], 401);
        } else {
            $request->user()->currentAccessToken()->delete();
            return response()->json(["message" => "Logout succesful"], 200);

        }
    } catch (\Exception $e){
        return response()->json(["message" => "Error logging out", "error" => $e->getMessage()], 500);
    }
   }

   public function User(Request $request){
      try{
        $user = Auth::user();
        if (!$user || Auth::check() === false){
            return response()->json(["message" => "User is not logged in"], 422);
        }
        $findUser = User::find($user->id);
        if ($findUser){
            $name = $user->name;
            $email = $user->email;
            $role = $user->role;
        } else {
            return response()->json(["message" => "User not found"], 404);
        }
        
        if ($findUser->role === "teacher" || $findUser->role === "admin"){
             $findPost = Announcement::query()->where("teacher_id", "LIKE", "%{$findUser}%")->paginate(10);
             return response()->json(["message" => "Successfully fetched announcements from user", "user" => $findUser, "announcement" => $findPost], 200);
        } else{
             return response()->json(["message" => "User doesnt have announcements"], 404);
        }
        
      } catch (\Exception $e){
        return response()->json(["message" => "Error finding user", "error" => $e->getMessage()], 500);
      }
   }
   


 
}
