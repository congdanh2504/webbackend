<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public static function saveFile($image) {
        try {
            $extension = $image->extension();
            $uuid = Str::uuid()->toString();
            $fileName = $uuid.'.'.$extension;
            $googleDriveStorage = Storage::disk('google');
            $googleDriveStorage->put($fileName, file_get_contents($image->getRealPath()));
            $fileinfo = collect($googleDriveStorage->listContents('/', false))
            ->where('type', 'file')
            ->where('name', $fileName)
            ->first();
            $contents = $fileinfo['path'];
            return "https://drive.google.com/uc?export=view&id=".$contents;
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        
    }
}
