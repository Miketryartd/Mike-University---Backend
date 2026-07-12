<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function Search(Request $request){
       try{
         $validate = $request->validate([
            "query" => "string|required"
        ]);
        $user = User::query()->where("name", 'LIKE', "%{$validate["query"]}%")->orWhere("email", 'LIKE', "%{$validate["query"]}%")->paginate(10);
        return response()->json(["message" => "Succesfully searched %{$validate["query"]}%", "user(s):" => $user], 200);
       } catch (\Exception $e){
        return response()->json(["message" => "Error searching user", "error" => $e->getMessage()], 500);
       }
        

    }

}
