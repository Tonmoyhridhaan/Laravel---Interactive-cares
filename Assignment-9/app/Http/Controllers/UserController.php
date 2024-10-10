<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function editProfile(Request $request){
        //dd($request->all());
        //dd(session('user')->id);
        //dd($request);
        $id = session('user')->id;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $email = $request->email;
        $bio = $request->bio;
        //echo $bio;
        $user = DB::table('users')->where('id', $id)->update([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'bio' => $bio,
            'updated_at' => now()
        ]);
        if($user){
            $user = DB::table('users')->where('id', $id)->first();
            $request->session()->put('user', $user);
            return redirect('/profile')->with('success', 'Succesfully updated');
        }
        

    }
    public function logout(Request $request){
        $request->session()->forget('user');
        return redirect('/login');
    }

}
