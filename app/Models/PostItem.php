<?php

namespace App\Models;

use App\Http\Controllers\ImageController;
use App\Http\Controllers\PaginationController;
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
        'rate',
        'like',
        'comment'
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
            'applies' => []
        ]);
    }

    public static function getAllPosts(){
        $projections=['id','companyId', 'title','nameJob','salary',
         'description', 'category', 'duration', 'address','imagesAddress',
        'applies', 'rate', 'like', 'comment', 'created_at'];
        $allPost= PostItem::all($projections);
        $allPostsWithUser = array();
        foreach($allPost as $post){
            $post->user;
            array_push($allPostsWithUser,$post);
        }
        $allPostsWithUser = array_reverse($allPostsWithUser, true);
        $data = PaginationController::paginate($allPostsWithUser, 4);
        return $data;
    }

    public static function getPostByID($id) {
        $post= PostItem::find($id);
        $post->user;
        return $post;
    }

    public static function getMyPosts($id){
        $myPost =PostItem::all()->where('companyId', $id);
        $myPostUser =array();
        foreach($myPost as $post){
            $post->user;
            array_push($myPostUser, $post);
        }
        $myPostUser = array_reverse($myPostUser, true);
        $data= PaginationController::Paginate($myPostUser, 4);
        return $data;
    }

    public static function updateJob(Request $request){
        $id = $request->input('id');
        $post= PostItem::find($id);
        $post->update($request->all());
        return $post;
    }

    public static function deleteJob($id){
        PostItem::find($id)->delete();
        return PostItem::all();
    }

    public static function searchJob($request){
        $location = $request->input('location');
        $keyword = $request->input('keyword');
        $posts = PostItem::where('address.detail', 'LIKE', "%".$location."%")
                        ->orWhere('nameJob', 'LIKE', "%$keyword%")
                        ->orWhere('category', 'LIKE', "%$keyword%")->get();
        $allPostsWithUser = array();
        foreach($posts as $post){
            $post->user;
            array_push($allPostsWithUser,$post);
        }
        $allPostsWithUser = array_reverse($allPostsWithUser, true);
        $data = PaginationController::paginate($allPostsWithUser, 4);
        return $data;
    }

    public static function addApply($request) {
        $postItemID = $request->input('postItemID');
        $employeeID = $request->input('employeeID');
        $postItem = PostItem::find($postItemID);
        $employee = User::find($employeeID);
        $postItem->push('applies', [
            '_id' => $employee['id'],
            'name' => $employee['name'],
            'avatarAddress' => $employee['avatarAddress']
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Successfully',
        ], 200);
    }
}
