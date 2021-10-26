<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Employer extends User
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
        $user->address = [ "province" => $document->city, "detail" => $document->address];     
        $user->mobile = $document->mobile;
        $user->description = $document->description;
        $user->save();
    }
}
