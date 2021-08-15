<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Connecting modules
use Validator;
use Auth;

// Connecting models
use App\Models\GameModel;

class GameController extends Controller
{
    // Add game page
    public function game_add_page() {
    	return view("game.game_add");
    }

    // Add game
    public function game_add(Request $request) {
        // Data validation
    	$validator = Validator::make($request->all(), [
    		"cover" => "required|max:1048|mimes:jpg,png",
    		"title" => "required|string|max:100",
    		"year_release" => "required|numeric|regex:/\d{4}/",
    		"description" => "required|string",
    	]);
        // If there are validation errors
    	if($validator->fails()) {
    		return response()->json([
    			"message" => "Validation error",
    			"errors" => $validator->errors(),
    		], 422);
    	}

    	// Image processing
    	$image_name = "1_". time() ."_". rand() .".". $request->file("cover")->extension();
    	$path = "public/images/". $image_name;

    	// Adding data to the database
    	$game = new GameModel;
    	$game->game_cover 		= $path;
    	$game->game_title 		= $request->input("title");
    	$game->game_release 	= $request->input("year_release");
    	$game->game_description = $request->input("description");
    	$game->developer_id 	= "0";
    	$game->save();

        // Adding an image to the server
        $request->file("cover")->move(public_path("images/"), $image_name);

    	// In case of success
    	return response()->json("Игра успешно добавлена", 200);
    }
}
