<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Connecting modules
use Validator;
use Auth;

// Connecting models
use App\Models\UserModel;

class AuthController extends Controller
{
    // Register page
    public function register_page() {
        return view("auth.register");
    }

    // Login page
    public function login_page() {
        return view("auth.login");
    }

    // Register
    public function register(Request $request) {
        // Data validation
        $validator = Validator::make($request->all(), [
            "username" => "required|string|max:100|min:3",
            "email" => "required|email|max:100",
            "login" => "required|string|max:100|min:3|unique:users,login",
            "password" => "required|string|max:100|min:3|required_with:password_check|same:password_check",
            "password_check" => "required|string|max:100|min:3",
        ]);

        // If there are validation errors
        if($validator->fails())
            return redirect()->route("register_page")->withErrors($validator, "register");

        // Instantiating the model
        $user = new UserModel;
        // Adding data to an instance
        $user->username = $request->input("username");
        $user->email = $request->input("email");
        $user->login = $request->input("login");
        $user->password = bcrypt($request->input("password"));
        $user->role = "user";
        // Saving an instance to the database
        $user->save();

        // In case of success
        return redirect()->route("register_page")->withErrors("Вы успешно зарегистрировались", "message");
    }

    // Login
    public function login(Request $request) {
        // Retrieving data
        $login = $request->input("login");
        $password = $request->input("password");

        // In case of authorization
        if(Auth::attempt(["login" => $login, "password" => $password], true))
            return redirect()->route("personal_area");
        // In case of not authorization
        else return redirect()->route("login_page")->withErrors("Ошибка логина или пароля", "login");
    }

    // Logout
    public function logout() {
    	// Logout from authorization
        Auth::logout();
        // Redirect to the main page with a message about the exit from authorization
        return redirect()->route("main_page")->withErrors("Вы вышли", "message");
    }
}
