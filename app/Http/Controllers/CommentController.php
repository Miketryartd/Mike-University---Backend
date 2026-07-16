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

    public function EditComment(Request $request){
         $validated = $request->validate([
                "newComment" => "string|required|max:255"
            ]);
        try{
        
            $user = Auth::user();
            if (!$user || Auth::check() === false){
                return response()->json(["message" => "User not authenticated"], 422);

            }
            $editedComment = Comment::find("user_id", $user->id)->where("comment")->first();
            return response()->json(["message" => "Succesfully edited comment", "comment" => $editedComment], 200);
        } catch (\Exception $e){
            return response()->json(["message" => "Error editing comment", "error" => $e->getMessage()], 500);
        }
    }
}
