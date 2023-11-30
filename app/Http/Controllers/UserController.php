<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    private $user;
    public function Register(Request $req)
    {

        $validate = Validator::make($req->all(), [
            'firstname' => 'required|String|max:50',
            'lastname' => 'required|String|max:50',
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'country' => 'required|string|max:50',
            'city' => 'required|string|max:30',
            'phonenumber' => 'required|string|max:10',
            'password' => 'required|string|min:8',
            'stateprovince' => 'required|string|max:100',
            'streetaddress' => 'required|string|max:100',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'validate_err' => $validate->messages(),
            ]);
        }

        $user = new User();
        $user->user_name = $req->username;
        $user->first_name = $req->firstname;
        $user->last_name = $req->lastname;
        $user->role = '0';
        $user->email = $req->email;
        $user->phone_number = $req->phonenumber;
        $user->country = $req->country;
        $user->city = $req->city;
        $user->password = $req->password;
        $user->state_province = $req->stateprovince;
        $user->street_address = $req->streetaddress;

        if ($req->hasFile('profilepicture')) {
            $image = $req->file('profilepicture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('User'), $imageName);

            $user->profile_picture = $imageName;
        }

        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product Added Successfully!',
            'result' => $user
        ]);
    }

    public function Login(Request $req)
    {

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            // return response()->json(['error' => 'Unauthorized'], 401);
            return response()->json([
                "status" => 400,
                "error" => "Email or password is incorrect!"
            ]);
        }

        $user = User::where('email', $req->email)->first();

        if ($user && Hash::check($req->password, $user->password)) {

            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'User Logged in Successfully!',
                'token_type' => 'Bearer',
                'token' => $token,
            ]);
        }
    }

    public function googlepage()
    {
        return Socialite::driver('google')->redirect();
        // return ('Welcome to googlepage controller function');
    }
    public function googleCallbackLogin()
    {
        $this->user = Socialite::driver('google')->user();

        // Check if the user exists
        $existingUser = User::where('google_id', $this->user->id)->first();

        if ($existingUser) {
            // Generate a token for the existing user
            $token = $existingUser->createToken('Google Login')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Login successful',
                'token_type' => 'Bearer',
                'token' => $token,
            ]);
        }

        // If the user doesn't exist, create a new user
        $newUser = User::create([
            'first_name' => $this->user->name,
            'email' => $this->user->email,
            'google_id' => $this->user->id,
            'password' => Hash::make('12345678'), // You can generate a random password or use a default one
        ]);

        // Generate a token for the new user
        $token = $newUser->createToken('Google_Login_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'User created successfully',
            'token_type' => 'Bearer',
            'token' => $token,
        ]);
    }
    public function getUserData()
    {
        $user = Auth::user();

        return response()->json([
            'status' => 200,
            'userlogin' => $user,
        ]);
    }
}
