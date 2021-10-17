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
        $document = json_decode($request->document);
        error_log($document->name);
        $image = $request->image;    
        $path = ImageController::saveFile($image);
        $user->name = $document->name;
        $user->dob = $document->dob;
        $user->address = [ "province" => $document->city, "detail" => $document->address];
        $user->avatarAddress = $path;
        $user->mobile = $document->mobile;
        $user->cv = $document->cv;
        $user->save();
    }
}
