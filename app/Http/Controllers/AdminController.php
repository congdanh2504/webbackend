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
        return PostItem::getAllPosts();
    }
}
