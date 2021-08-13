<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Connecting modules
use Validator;
use Auth;

// Connecting models
use App\Models\UserModel;

class UserController extends Controller
{
    // Personal area
    public function personal_area() {
    	$user = Auth::user();
    	$data = (object)["user" => $user];
    	return view("personal_area", ["data" => $data]);
    }
	// User data update page
    public function personal_area_update_page() {
    	$user = Auth::user();
    	$data = (object)["user" => $user];
    	return view("user.update", ["data" => $data]);
    }

	// User data update
	public function personal_area_update(Request $request) {
        // Data validation
        $validator = Validator::make($request->all(), [
            "username" => "required|string|max:100|min:3",
            "email" => "required|email|max:100",
            "password" => "required|string|max:100|min:3|required_with:password_check|same:password_check",
            "password_check" => "required|string|max:100|min:3",
        ]);

        // If there are validation errors
        if($validator->fails())
            return redirect()->route("personal_area_update")->withErrors($validator, "register");

        // Getting a user
        $user_id = Auth::id();
        $user = UserModel::find($user_id);
        // Data update
        $user->username = $request->input("username");
        $user->email = $request->input("email");
        $user->password = bcrypt($request->input("password"));
        $user->role = "user";
        // Saving data
        $user->save();

        // In case of success
        return redirect()->route("personal_area")->withErrors("Данные успешно изменены", "message");
	}

	// Delete user
	public function personal_area_delete() {
		// Gettin a user
		$user_id = Auth::id();
		$user = UserModel::find($user_id);
		// Delete user
		$user->delete();
        // In case of success
		return redirect()->route("main_page")->withErrors("Страница успешно удалён", "message");
	}
}
