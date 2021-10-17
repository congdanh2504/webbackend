<?php

namespace App\Http\Controllers;

use App\Models\PostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected function getAllPosts() {
        return DB::collection('postItems')->paginate(10);
    }

    protected function postJob(Request $request){
        return PostItem::postJob($request);
    }

    protected function getPost($id){
        return PostItem::getPost($id);
    }

    protected function update(Request $request, $id){
        return PostItem::updateJob($request, $id);
    }
}
