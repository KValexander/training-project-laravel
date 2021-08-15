<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Connecting modules
use Validator;

// Connecting models
use App\Models\GenreModel;

class GenreController extends Controller
{
    // Genre page
    public function genre_page() {
    	// Get all genres
    	$genres = GenreModel::all();
    	$data = (object)["genres" => $genres];
    	// Return data
    	return view("moderation.genre", ["data" => $data]);
    }

    // Add genre
    public function genre_add(Request $request) {
        // Data validation
    	$validator = Validator::make($request->all(), [
    		"genre" => "required|string|max:100|unique:genres,genre"
    	]);
        // If there are validation errors
    	if($validator->fails()) {
    		return response()->json([
    			"message" => "Validation errors",
    			"errors" => $validator->errors()
    		], 422);
    	}

    	// Adding data to the database
    	$genre = new GenreModel;
    	$genre->genre = $request->input("genre");
    	$genre->save();

    	// In case of success
    	$genres = GenreModel::all();
    	return response()->json([
    		"message" => "Жанр успешно добавлен",
    		"genres" => $genres
    	], 200);
    }

    // Delete genre
    public function genre_delete(Request $request) {
    	// Get genre id
    	$genre_id = $request->input("genre_id");

    	// Delete genre
    	$genre = GenreModel::find($genre_id);
    	if($genre == NULL) return;
    	$genre->delete();

    	// In case of success
    	$genres = GenreModel::all();
    	return response()->json([
    		"message" => "Жанр успешно удалён",
    		"genres" => $genres
    	], 200);
    }

}
