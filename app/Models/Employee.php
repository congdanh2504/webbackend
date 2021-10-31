<?php

namespace App\Models;

use App\Http\Controllers\ImageController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Employee extends User
{
    use HasFactory;

    public static function updateProfile(Request $request) {
        $user = Auth::user();
        if ($request->hasFile('image')){
            $image = $request->image; 
            $path = ImageController::saveFile($image);
            $user->avatarAddress = $path;
        }  
        $document = json_decode($request->document); 
        $user->name = $document->name;
        $user->dob = $document->dob;
        $user->address = [ "province" => $document->city, "detail" => $document->address];     
        $user->mobile = $document->mobile;
        $user->cv = $document->cv;
        $user->save();
    }

    public static function addReview(Request $request) {
        $id = $request->input('id');
        $employer = User::find($id);
        $rate = $request->input('rate');
        $title = $request->input('title');
        $message = $request->input('message');
        $user = Auth::user();


        $oldRate = intval($employer->rate['count']);
        $oldAvg = floatval($employer->rate['avg']);
        $newAvg = (($oldAvg*$oldRate) + $rate) / ($oldRate + 1);
        $newRate = $oldRate + 1;
        
        $employer->rate = [
            "count" => $newRate,
            "avg" => $newAvg
        ];
        $employer->save();

        $employer->push('reviews', [
            'user' => [
                "userID" => $user['id'],
                "name" => $user['name'],
                "avatarAddress" => $user['avatarAddress']
            ],
            'rate' => $rate,
            "title" => $title,
            'message' => $message
        ]);
    }
}
