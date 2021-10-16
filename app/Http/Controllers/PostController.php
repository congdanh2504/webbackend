<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected function getAllPosts() {
        DB::collection('PostItems')->paginate(10);
    }
}
