<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ImageController;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function employers() {
      return User::where('type', '=', 'Employer')->orderBy('rate.avg', 'desc')->Paginate(10);
    }

    public function employerUpdateProfile(Request $request){
      return Employer::updateProfile($request);
    }
    
}
