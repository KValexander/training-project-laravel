<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Connecting models
use App\Models\GameModel;
use App\Models\DeveloperModel;

class MainController extends Controller
{
    // Main page
    public function main_page() {
    	// Get data
    	$games = GameModel::where("state", 1)->orderBy("updated_at", "DESC")->get();
    	$developers = DeveloperModel::where("state", 1)->orderBy("updated_at", "DESC")->get();
    	// Composing an object
    	$data = (object)[
    		"games" => $games,
    		"developers" => $developers,
    	];
    	// Return view with data
    	return view("index", ["data" => $data]);
    }
}
