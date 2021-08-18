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
    	$games = GameModel::where("state", 0)->get();
    	$developers = DeveloperModel::where("state", 0)->get();
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
