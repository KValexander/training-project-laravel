<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Connecting models
use App\Models\UserModel;
use App\Models\GameModel;
use App\Models\DeveloperModel;

class ModerationController extends Controller
{
    // Moderation page
    public function moderation_page() {
    	// Get data
    	$users = UserModel::all();
    	$games = GameModel::all();
    	$developers = DeveloperModel::all();
    	// Composing an object
    	$data = (object)[
    		"users" => $users,
    		"games" => $games,
    		"developers" => $developers,
    	];
    	// Return view with data
    	return view("moderation.moderation", ["data" => $data]);
    }

    // Approve developer
    public function approve_developer(Request $request) {
    	// Get developer id
    	$developer_id = $request->input("developer_id");
    	// Get developer
    	$developer = DeveloperModel::find($developer_id);
    	// Update data
    	$developer->state = 1;
    	$developer->save();
    	// In case of success
    	return redirect()->route("moderation_page")->withErrors("Разработчик ". $developer->developer_title . " одобрен", "message");
    }

    // Approve game
    public function approve_game(Request $request) {
    	// Get game id
    	$game_id = $request->input("game_id");
    	// Get game
    	$game = GameModel::find($game_id);
    	// Update data
    	$game->state = 1;
    	$game->save();
    	// In case of success
    	return redirect()->route("moderation_page")->withErrors("Игра ". $game->game_title . " одобрена", "message");
    }

    // Condemn developer
    public function condemn_developer(Request $request) {
        // Get id
        $id = $request->input("developer_id");
        // Get developer
        $developer = DeveloperModel::find($id);
        // Update data
        $developer->state = 0;
        $developer->save();
        // In case of success
        return redirect()->route("moderation_page")->withErrors("Разработчик ". $developer->developer_title . " отправлен на модерацию", "message");
    }

    // Condemn game
    public function condemn_game(Request $request) {
        // Get id
        $id = $request->input("game_id");
        // Get game
        $game = GameModel::find($id);
        // Update data
        $game->state = 0;
        $game->save();
        // In case of success
        return redirect()->route("moderation_page")->withErrors("Игра ". $game->game_title . " отправлена на модерацию", "message");
    }

    // Search users
    public function search_users(Request $request) {
        // Get query
        $query = $request->input("query");
        // Search data
        $data = UserModel::where("id", $query)
            ->orWhere("login", "LIKE", "%". $query ."%")
            ->orWhere("username", "LIKE", "%". $query ."%")
            ->orWhere("email")
            ->get();
        if($query == "") $data = UserModel::all();
        // Return response
        return response()->json(["data" => $data], 200);
    }

    // Search developers
    public function search_developers(Request $request) {
        // Get query
        $query = $request->input("query");
        // Search data
        $data = DeveloperModel::where("id", $query)
            ->orWhere("developer_title", "LIKE", "%". $query ."%")
            ->orWhere("developer_foundation", "LIKE", "%". $query ."%")
            ->get();
        if($query == "") $data = DeveloperModel::all();
        // Return response
        return response()->json(["data" => $data], 200);
    }

    // Search games
    public function search_games(Request $request) {
        // Get query
        $query = $request->input("query");
        // Search data
        $data = GameModel::where("id", $query)
            ->orWhere("game_title", "LIKE", "%". $query ."%")
            ->orWhere("game_release", "LIKE", "%". $query ."%")
            ->get();
        if($query == "") $data = GameModel::all();
        // Return response
        return response()->json(["data" => $data], 200);
    }

    // Delete user
    public function delete_user(Request $request) {
    	// Get user id
    	$user_id = $request->input("user_id");
    	// Get user
    	$user = UserModel::find($user_id);
    	$login = $user->login;
    	// Delete user
    	$user->delete();

    	// In case of success
    	return redirect()->route("moderation_page")->withErrors("Пользователь ". $login ." успешно удалён", "message");
    }
}
