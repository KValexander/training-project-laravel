<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Connecting modules
use Auth;

class UserController extends Controller
{
    // Personal area
    public function personal_area() {
    	$user = Auth::user();
    	$data = (object)["user" => $user];
    	return view("personal_area", ["data" => $data]);
    }
}
