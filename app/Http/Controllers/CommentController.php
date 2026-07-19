<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function AddComment(Request $request)
    {
        try {
            $validated = $request->validate([
                "comment" => "required|string|max:1000",
                "announcement_id" => "required|exists:announcements,id"
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json(["message" => "User not authenticated"], 401);
            }

            $announcement = Announcement::find($validated["announcement_id"]);
            if (!$announcement) {
                return response()->json(["message" => "Announcement not found"], 404);
            }

            $userType = $user->role;
            
            $comment = Comment::create([
                "user_type" => $userType,
                "user_id" => $user->id,
                "announcement_id" => $validated["announcement_id"],
                "comment" => $validated["comment"]
            ]);

            return response()->json([
                "message" => "Comment added successfully", 
                "comment" => $comment->load('user')
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error adding comment", 
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function EditComment(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                "comment" => "required|string|max:1000"
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json(["message" => "User not authenticated"], 401);
            }

            $comment = Comment::where("id", $id)->where("user_id", $user->id)->first();
            
            if (!$comment) {
                return response()->json(["message" => "Comment not found or you don't have permission to edit"], 404);
            }

            $comment->update([
                "comment" => $validated["comment"]
            ]);

            return response()->json([
                "message" => "Comment updated successfully",
                "comment" => $comment
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error updating comment",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function DeleteComment($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(["message" => "User not authenticated"], 401);
            }

            $comment = Comment::where("id", $id)->where("user_id", $user->id)->first();
            
            if (!$comment) {
                return response()->json(["message" => "Comment not found or you don't have permission to delete"], 404);
            }

            $comment->delete();

            return response()->json([
                "message" => "Comment deleted successfully"
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error deleting comment",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function GetComments($announcementId)
    {
        try {
            $comments = Comment::where("announcement_id", $announcementId)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                "comments" => $comments
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error fetching comments",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}