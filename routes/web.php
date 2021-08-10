<?php

use Illuminate\Support\Facades\Route;

// Connecting controllers
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

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
// Route::group(["middleware" => "auth"], function() {
// });

// Logout
Route::get("/logout", [AuthController::class, "logout"])->name("logout");