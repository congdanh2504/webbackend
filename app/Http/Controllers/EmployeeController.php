<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function getAllEmployers() {
        return User::where('type', '=', 'employer');
    }
}