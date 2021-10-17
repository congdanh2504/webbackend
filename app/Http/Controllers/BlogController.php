<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BlogController extends Controller
{
    protected function getAllBlogs() {
        $projections = ['id', 'imageAddress', 'title', 'created_at', 'views', 'userId'];
        $data = Blog::all($projections);
        $datat = array();
        foreach($data as $blog) {
            $blog->user;
            array_push($datat, $blog);
        }
        $data = PaginationController::paginate($datat, 3);
        return $data;
    }

    protected function addBlog(Request $request) {
        return Blog::addBlog($request);
    }

    protected function getById($id) {
        return Blog::getById($id);
    }
}
