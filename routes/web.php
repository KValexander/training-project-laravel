<?php

use Illuminate\Support\Facades\Route;

// Connecting controllers
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Session group
Route::group(["middleware" => "session"], function() {

	// Main page
	Route::get("/", [MainController::class, "main_page"])->name("main_page");

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
		
		// Personal area
		Route::get("/personal_area", [UserController::class, "personal_area"])->name("personal_area");

		// Logout
		Route::get("/logout", [AuthController::class, "logout"])->name("logout");
	
	});
});