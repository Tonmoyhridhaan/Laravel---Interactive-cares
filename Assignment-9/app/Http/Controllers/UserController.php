<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function registration(Request $request){
        //dd($request->all());
        $name = $request->name;
        $firstName = "";
        $lastName = "";
        $lastSpacePos = strrpos($name, ' ');

        if ($lastSpacePos === false) {
            $firstName = $name;
            $lastName = '';
        } else {
            $firstName = substr($name, 0, $lastSpacePos);
            $lastName = substr($name, $lastSpacePos + 1); 
        }

        try {
            $user = DB::table('users')->insert([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'userName' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            if($user){
                return redirect('/login')->with('success', 'Succesfully registered');;
            }
        } catch (\Exception $e) {
            return redirect('/registration')->with('error', 'Something is wrong!!!');
        }
        
    }

    public function login(Request $request){
        //dd($request->all());

        $email = $request->email;
        $password = $request->password;
        $user = DB::table('users')->where('email', $email)->first();
        if($user){
            if(Hash::check($password, $user->password)){
                $request->session()->put('user', $user);
                return redirect('/');
            }else{
                return redirect('/login')->with('error', 'Wrong password');
            }
        }else{
            return redirect('/login')->with('error', 'User not found');
        }
    }

    public function editProfile(Request $request)
    {
        // Validate the request data including the avatar image
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $id = session('user')->id;
    
        // Handle image upload if there's an image
        $avatarPath = session('user')->image; // Default to existing avatar path
        if ($request->hasFile('image')) {
            if ($avatarPath) {
                Storage::delete('public/' . $avatarPath);
            }
            // Store the new avatar in the 'public/avatars' directory
            $avatarPath = $request->file('image')->store('images', 'public');
        }
    
        // Update the user data
        DB::table('users')->where('id', $id)->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'bio' => $request->bio,
            'image' => $avatarPath, // Store the new avatar path
            'updated_at' => now()
        ]);
    
        // Refresh the session with updated user data
        $user = DB::table('users')->where('id', $id)->first();
        $request->session()->put('user', $user);
    
        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }
    
    public function logout(Request $request){
        $request->session()->forget('user');
        return redirect('/login');
    }

}
