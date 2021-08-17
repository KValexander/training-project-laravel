<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Connecting modules
use Validator;
use Auth;

// Connection models
use App\Models\DeveloperModel;

class DeveloperController extends Controller
{
    // Add developer page
    public function developer_add_page() {
    	return view("developer.developer_add");
    }

    // Add developer
    public function developer_add(Request $request) {
        // Data validation
    	$validator = Validator::make($request->all(), [
    		"title" => "required|string|max:100",
    		"year_foundation" => "required|numeric|regex:/^20\d{2}$/",
    		"description" => "required|string",
    	]);
        // If there are validation errors
        if($validator->fails()) {
        	return response()->json([
        		"message" => "Validation errors",
        		"errors" => $validator->errors()
        	], 422);
        }

    	// Adding data to the database
        $developer = new DeveloperModel;
        $developer->user_id = Auth::id();
        $developer->developer_title = $request->input("title");
        $developer->developer_foundation = $request->input("year_foundation");
        $developer->developer_description = $request->input("description");
        $developer->save();

        // In case of success
        return response()->json("Разработчик отправлен на модерацию", 200);
    }
}
