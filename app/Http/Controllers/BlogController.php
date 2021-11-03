<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    protected function getAllBlogs() {
        return Blog::getAllBlogs();
    }

    protected function getNewBlogs($limit){
        return Blog::getNewBlogs($limit);
    }

    protected function addBlog(Request $request) {
        return Blog::addBlog($request);
    }

    protected function getById($id) {
        return Blog::getById($id);
    }
}
