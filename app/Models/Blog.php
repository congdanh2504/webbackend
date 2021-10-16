<?php

namespace App\Models;

use App\Http\Controllers\ImageController;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model;


class Blog extends Model
{
    use HasFactory;
    protected $collection = 'blogs';
    protected $fillable = [
        "userId",
        "views",
        "title",
        "description",
        "imageAddress",
        "content"
    ];

    public function user() {
        return $this->belongsTo(User::class, 'userId');
    }

    public static function addBlog(Request $request) {
        $document = json_decode($request->document);
        $image = $request->image;    
        $path = ImageController::saveFile($image);
        $user = Auth::user();
        $userId = $user['id'];
        $title = $document->title;
        $description = $document->description;
        $content = $document->content;    
        
        Blog::create([
            'userId' => $userId,
            'title' => $title,
            'content' => $content,
            'description' => $description,
            'imageAddress' => $path,
            'views' => 0
        ]);
    }

    public static function getById($id) {
        $blog = Blog::find($id);
        $blog->views = $blog->views + 1;
        $blog->save();
        $blog->user;
        return $blog;
    }
}
