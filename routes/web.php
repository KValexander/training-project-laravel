<?php

use Illuminate\Support\Facades\Route;

// Connecting controllers
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\ModerationController;

// Session group
Route::group(["middleware" => "session"], function() {

	// Main page
	Route::get("/", [MainController::class, "main_page"])->name("main_page");

	// Developer page
	Route::get("/developers/{id}", [DeveloperController::class, "developer_page"])->name("developer_page");

	// Register page
	Route::get("/register", [AuthController::class, "register_page"])->name("register_page");
	// Register
	Route::post("/register", [AuthController::class, "register"])->name("register");

	// Login page
	Route::get("/login", [AuthController::class, "login_page"])->name("login_page");
	// login
	Route::post("/login", [AuthController::class, "login"])->name("login");

	// Auth Group
	Route::group(["middleware" => "auth"], function() {

		// Add game page
		Route::get("/game/add", [GameController::class, "game_add_page"])->name("game_add_page");

		// Add game
		Route::post("/game/add", [GameController::class, "game_add"])->name("game_add");

		// Add developer page
		Route::get("/developer/add/", [DeveloperController::class, "developer_add_page"])->name("developer_add_page");

		// Add developer
		Route::post("/developer/add/", [DeveloperController::class, "developer_add"])->name("developer_add");
		
		// Personal area
		Route::get("/personal_area", [UserController::class, "personal_area"])->name("personal_area");

		// User data update page
		Route::get("/personal_area/update", [UserController::class, "personal_area_update_page"])->name("personal_area_update_page");

		// User data update
		Route::post("/personal_area/update", [UserController::class, "personal_area_update"])->name("personal_area_update");

		// Delete user
		Route::get("/personal_area/delete", [UserController::class, "personal_area_delete"])->name("personal_area_delete");

		// Moderation routes
		Route::group(["middleware" => "moderation"], function() {

			// Moderation page
			Route::get("/moderation", [ModerationController::class, "moderation_page"])->name("moderation_page");

			// Approve developer
			Route::get("/moderation/approve/developer", [ModerationController::class, "approve_developer"])->name("moderation_approve_developer");

			// Approve game

			Route::get("/moderation/approve/game", [ModerationController::class, "approve_game"])->name("moderation_approve_game");
			// Detele user
			Route::get("/moderation/delete/user", [ModerationController::class, "delete_user"])->name("moderation_delete_user");

			// Genre page
			Route::get("/genre", [GenreController::class, "genre_page"])->name("genre_page");

			// Add genre
			Route::post("/genre/add", [GenreController::class, "genre_add"])->name("genre_add");

			// Delete genre
			Route::get("/genre/delete", [GenreController::class, "genre_delete"])->name("genre_delete");

		});

		// Logout
		Route::get("/logout", [AuthController::class, "logout"])->name("logout");
	
	});
});