<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AnnouncementController extends Controller
{
    
    public function CreateAnnouncement(Request $request){
        try{
            $user = Auth::user();
            if (!$user || Auth::check() === false){
                return response()->json(["message" => "User is not authenticated"], 422);
            }
           
            $validated = $request->validate([
                "title" => "string|required|max:255",
                "body" => "string|required|max:255"
            ]);

           $checkRole = $user->role === "teacher";
           if ($checkRole){
            $newAnnouncement = Announcement::create([
                "title" => $validated["title"],
                "body" => $validated["body"],
                "teacher_id" => $user->id
            ]);
            return response()->json(["message" => "Succesfully created announcement", "announcement" => $newAnnouncement], 200);
           } else {
            return response()->json(["mssage" => "Error creating announcement"], 401);
           }
        } catch (\Exception $e){
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    
    public function GetAnnouncement(int $page){

    try{
        $user = Auth::user();
        if (!$user || Auth::check() === false){
            return response()->json(["message" => "User is not authenticated"], 422);
        }
        $announcement = Announcement::with("user")->latest()->paginate($page || 10);
        return response()->json(["message" => "Announcements fetched succesfully", "announcements" => $announcement], 200);
    } catch (\Exception $e){
        return response()->json(["message" => $e->getMessage()], 500);
    }
    }

}
