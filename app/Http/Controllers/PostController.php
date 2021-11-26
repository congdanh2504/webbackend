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

    protected function search(Request $request){
        return PostItem::searchJob($request);
    }

    protected function updateJob(Request $request){
        return PostItem::updateJob($request);
    }

    public function addApply(Request $request) {
        return PostItem::addApply($request);
    }
  
    public function response(Request $request) {
        return PostItem::response($request);
    }
}
