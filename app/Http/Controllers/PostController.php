<?php

namespace App\Http\Controllers;

use App\Models\PostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected function getAllPosts() {
        DB::collection('postItems')->paginate(10);
    }

    protected function postJob(Request $request){
        return PostItem::postJob($request);
    }
}
