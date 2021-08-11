<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    // Main page
    public function main_page() {
    	return view("index");
    }
}
