<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModerationController extends Controller
{
    // Moderation page
    public function moderation_page() {
    	return view("moderation/moderation");
    }
}
