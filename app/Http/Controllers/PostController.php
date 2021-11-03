<?php

namespace App\Http\Controllers;

use App\Models\PostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected function getAllPosts() {
        return PostItem::getAllPosts();
    }

    protected function postJob(Request $request){
        return PostItem::postJob($request);
    }

    protected function getPostByID($id){
        return PostItem::getPostByID($id);
    }

    protected function getMyPosts($id){
        return PostItem::getMyPosts($id);
    }

    protected function update(Request $request, $id){
        return PostItem::updateJob($request, $id);
    }

    protected function delete($id){
        return PostItem::deleteJob($id);
    }
}
