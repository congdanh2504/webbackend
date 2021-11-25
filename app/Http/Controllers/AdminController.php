<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\PostItem;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function employees(){
        return User::where('type', '=','Employee')->Paginate(10);
    }

    public function employers(){
        return User::where('type', '=','Employer')->Paginate(10);
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->getAllUserBlogs()->delete();
        $user->delete();
        return $this->employees();
    }

    public function deleteBlog($id) {
        $blog = Blog::find($id);
        $blog->delete();
        return Blog::getAllBlogs();
    }

    public function deletePostItem($id) {
        $postItem = PostItem::find($id);
        $postItem->delete();
    }

    public function report() {
        $countByMonth = ['m01' => 0, 'm02' => 0, 'm03' => 0,'m04' => 0,'m05' => 0,'m06' => 0,'m07' => 0,'m08' => 0,'m09' => 0,'m10' => 0,'m11' => 0,'m12' => 0];
        $postItems = PostItem::all();
        foreach ($postItems as $postItem) {
            $date = $postItem['created_at'];
            $year = substr($date, 0, 4);
            if (date("Y") == $year) {
                $month = substr($date, 5, 2);
                $countByMonth["m$month"] += 1;
            }
        }
        $numOfEmployees = User::where('type', "Employee")->get()->count();
        $numOfEmployers = User::where('type', "Employer")->get()->count();
        $numOfBlogs = Blog::all()->count();
        $numOfJobs = PostItem::all()->count();
        $numOfReceptionist = PostItem::where("category", 'Receptionist')->get()->count();
        $numOfWebDeveloper = PostItem::where("category", 'Web developer')->get()->count();
        $numOfDesigner = PostItem::where("category", 'Designer')->get()->count();
        $numOfEditor = PostItem::where("category", 'Editor')->get()->count();
        $numOfProgrammer = PostItem::where("category", 'Programmer')->get()->count();
        return response()->json([
            'status' => true,
            'report' => [
                'numOfEmployees' => $numOfEmployees,
                'numOfEmployers' => $numOfEmployers,
                'numOfBlogs' => $numOfBlogs,
                'numOfJobs' => $numOfJobs,
                'numOfReceptionist' => $numOfReceptionist,
                'numOfWebDeveloper' => $numOfWebDeveloper,
                'numOfDesigner' => $numOfDesigner,
                'numOfEditor' => $numOfEditor,
                'numOfProgrammer' => $numOfProgrammer,
                'countByMonth' => $countByMonth
            ]
        ]);
    }

    public function findUser(Request $request){
        $keyword = $request->input('keyword');
        if($keyword === null){
            return User::where('type', 'Employee')->Paginate(10);
        }
        return User::where('name', 'like',  "%$keyword%")
                    ->where('type', 'Employee')->Paginate(10);
    }

    public function findCompany(Request $request){
        $keyword = $request->input('keyword');
        if($keyword === null){
            return User::where('type', 'Employer')->Paginate(10);
        }
        return User::where('name', 'like',  "%$keyword%")
                    ->where('type', 'Employer')->Paginate(10);
    }

    public function findPost(Request $request){
        $keyword = $request->input('keyword');
        if($keyword === null){
            return PostItem::getAllPosts();
        }
        $posts= PostItem::where('title', 'like',  "%$keyword%")
                    ->orWhere('nameJob', 'like',  "%$keyword%")->get();
        $postsWithUser = array();
        foreach($posts as $post) {
            $post->user;
            array_push($postsWithUser, $post);
        }
        return  PaginationController::paginate($postsWithUser, 10);
    }

    public function findBlog(Request $request){
        $keyword = $request->input('keyword');
        if($keyword === null){
            return Blog::getAllBlogs();
        }
        $blogs =Blog::where('title', 'like',  "%$keyword%")->get();
        $blogsWithUser = array();
        foreach($blogs as $blog) {
            $blog->user;
            array_push($blogsWithUser, $blog);
        }
        return  PaginationController::paginate($blogsWithUser, 10);
    }

}
