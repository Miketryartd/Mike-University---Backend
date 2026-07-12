<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function AddComment(Request $request){
        try{
            $validated = $request->validate([
                "comment" => "required|string"
            ]);

            $user = Auth::user();
            if (!$user || Auth::check() === false){
                return response()->json(["message" => "User is not authenticated to comment"], 422);
            }
            $userType = User::find($user->id)->where("role");
            $newComment = Comment::create([
                "user_type" => $userType,
                
                "comment" => $validated["comment"]
            ]);

            return response()->json(["message" => "Comment added succesfully", "comment" => $newComment], 200);
            
        } catch (\Exception $e){
            return response()->json(["message" => "Error adding comment", "error" => $e->getMessage()], 500);
        }
    }
}
