<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BlogController extends Controller
{
    protected function getAllBlogs() {
        // $fileinfo = collect($googleDriveStorage->listContents('/', false))
        // ->where('type', 'file')
        // ->where('name', 'top-5-blogs-job-seekers-99175332.jpg')
        // ->first();
        // $contents = $fileinfo['path'];
        
        $projections = ['id', 'imageAddress', 'title', 'created_at', 'views'];
        return Db::collection('blogs')->paginate(3, $projections);
    }

    protected function addBlog(Request $request) {
        return Blog::addBlog($request);
    }

    protected function getById($id) {
        return Blog::getById($id);
    }
}
