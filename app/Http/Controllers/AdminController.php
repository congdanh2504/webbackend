<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function employees(){
        return User::where('type', '=','Employee')->Paginate(15);
    }

    public function employers(){
        return User::where('type', '=','Employer')->Paginate(15);
    }
}
