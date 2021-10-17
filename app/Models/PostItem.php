<?php

namespace App\Models;

use App\Http\Controllers\ImageController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostItem extends Model
{
    use HasFactory;
    protected $collection = 'postItems';
    protected $fillable = [
        "companyId",
        "title",
        "nameJob",
        "description",
        "category",
        "salary",
        "duration",
        "address",
        "imagesAddress",
        "applies", 
    ];

    public function user() {
        return $this->belongsTo(User::class, 'companyId');
        // a post belong to a company
    }
    
    public static function postJob(Request $request) {
        $document = json_decode($request->document);

        $user = Auth::user();
        $companyId = $user['id']; //get id of company/employer
        $image = $request->image;
        $path = ImageController::saveFile($image);
        $title = $document->title;
        $nameJob = $document->nameJob;
        $description = $document->description;
        $category =  $document->category;
        $salary = $document->salary;
        $duration = $document->duration;
        $province = $document->province;
        $detailedAddress = $document->detailedAddress;

        PostItem::create([
            'companyId' => $companyId,
            'imagesAddress' => $path,
            'title' => $title,
            'nameJob' => $nameJob,
            'description' => $description,
            'category' => $category,
            'salary' => $salary,
            'duration' => $duration,
            'address' => [
                'province' => $province,
                'detail' =>$detailedAddress,
            ],
            'applies' => 0
        ]);
    }

    public static function getPost($id) {
        return PostItem::find($id);
    }

    public static function updateJob(Request $request, $id){
        $post= PostItem::find($id);
        $post->update($request->all());
        return $post;
    }

    public static function deleteJob($id){
        PostItem::find($id)->delete();
        return PostItem::all();
    }
}
