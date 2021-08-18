<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Connecting modules
use Validator;
use Auth;

// Connecting models
use App\Models\GameModel;
use App\Models\GenreModel;
use App\Models\DeveloperModel;
use App\Models\GameGenreModel;

class GameController extends Controller
{
    // Add game page
    public function game_add_page() {
        // Get data
        $genres = GenreModel::all();
        $developers = DeveloperModel::where("state", "1")->get();
        // Composing object
        $data = (object)[
            "genres" => $genres,
            "developers" => $developers
        ];
        // Return view with data
    	return view("game.game_add", ["data" => $data]);
    }

    // Add game
    public function game_add(Request $request) {
        // Data validation
    	$validator = Validator::make($request->all(), [
    		"cover" => "required|max:1048|mimes:jpg,png",
    		"title" => "required|string|max:100",
    		"year_release" => "required|numeric|regex:/^20\d{2}$/",
    		"description" => "required|string",
            "genres" => "required",
            "developer_id" => "required|numeric"
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
        $game->user_id = Auth::id();
    	$game->game_cover = $path;
    	$game->game_title = $request->input("title");
    	$game->game_release = $request->input("year_release");
    	$game->game_description = $request->input("description");
    	$game->developer_id = $request->input("developer_id");
    	$game->save();

        // Adding genres
        $genres = explode(",", $request->input("genres"));
        foreach($genres as $id) {
            $ggm = new GameGenreModel;
            $ggm->game_id = $game->id;
            $ggm->genre_id = $id;
            $ggm->save();
        }

        // Adding an image to the server
        $request->file("cover")->move(public_path("images/"), $image_name);

    	// In case of success
    	return response()->json("Игра отправлена на модерацию", 200);
    }
}
