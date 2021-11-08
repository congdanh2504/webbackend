<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function employers() {
        return User::where('type', '=', 'Employer')->orderBy('rate.avg', 'desc')->Paginate(10);
    }

    public function employeeUpdateProfile(Request $request) {
        return Employee::updateProfile($request);
    }

    public function addReview(Request $request) {
        return Employee::addReview($request);
    }
}
