<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ImageController;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
  public function employerUpdateProfile(Request $request){
    return Employer::updateProfile($request);
  }
    
}
