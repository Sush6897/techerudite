<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class RegistrationController extends Controller
{
    //

    public function index(){
        return view('register');
    }
    public function register(Request $request){
        
        $this->validate($request, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $user = User::create([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'role' => $request->role,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            
        ]);

        if(!empty($user)){
            
            Mail::send('email.welcome', ['user'=>$user], function ($message) use ($request) {
                $message->to($request->email)->subject('Welcome to Techerudite');
            });
            if($request->role=='Customer'){
                return redirect()->route('user.login')->with('success','please check email to login');    

            }else{
                return redirect()->route('login')->with('success','please check email to login');    

            }
        }else{
            return back()->with('error','user not created'); 
        }
        
    }

    public function verifyEmail($id){
        
        $user = User::where('id', $id)->first();
        if(!empty($user)){
            $data=[
                "email_verified_at"=>now(),
                'email_sent'=>1,
            ];
            User::where('id', $id)->update($data);
            return redirect()->route('login')->with('success','Email verified Successfully');
        }else{
            return redirect()->route('login')->with('error','User Not Found');
        }
    }

    public function login(){
        return view('login');
    }

    public function loginpost(Request $request){
        
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $credentials['email']= $request['email'];
        $credentials['password']= $request['password'];
        $user = User::where('email', $request->email)->first();
        if(!empty($user)){
            if (Auth::attempt($credentials + ["role" => "Admin"] + ["email_sent" => "1"])){

                return redirect()->route('dashboard')->with('success', 'login successfully');
            } elseif (Auth::attempt($credentials + ["role" => "Admin", "email_sent" => "0"])){
                return back()->with('error','please check email and verify your account');
            }else{
                return back()->with('error','You are not allowed to login from here');
            }
        }else{
            return back()->with('error','User not found');
        }
       
        
    }

    public function adminregister(){
        return view('adminregister');
    }

    public function dashboard(){
        if(!empty(Auth::user()->id)){
            return view('dashboard');
        }else{
            return back()->with('error', "You need to login first");
        }
        
    }

    public function logout(Request $request){
        Auth::guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('login')->with('success', "logout successfully");
        
    }

    public function userlogin(){
        return view('userlogin');

    }

    public function userpost(Request $request){
        
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $credentials['email']= $request['email'];
        $credentials['password']= $request['password'];
        $user = User::where('email', $request->email)->first();
        if(!empty($user)){
            if (Auth::attempt($credentials + ["role" => "Customer"] + ["email_sent" => "1"])){

                return redirect()->route('dashboard')->with('success', 'login successfully');
            } elseif (Auth::attempt($credentials + ["role" => "Customer", "email_sent" => "0"])){
                return back()->with('error','please check email and verify your account');
            }else{
                return back()->with('error','You are not allowed to login from here');
            }
        }else{
            return back()->with('error','User not found');
        }
    }
}
